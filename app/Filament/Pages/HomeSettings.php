<?php

namespace App\Filament\Pages;

use App\Models\Image;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class HomeSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Главная';

    protected static ?string $title = 'Настройки главной страницы';

    protected static ?int $navigationSort = -1;

    public ?array $data = [];

    public function mount(): void
    {
        $logo         = Setting::get('logo');
        $heroImage    = Setting::get('hero_image');
        $contactImage = Setting::get('contact_image');
        $portfolio = Image::where('type', 'portfolio')->orderBy('id')
            ->get()
            ->map(fn ($img) => ['path' => [$img->path], 'alt' => $img->alt ?? ''])
            ->toArray();

        $this->form->fill([
            'logo'             => $logo         ? [$logo]         : [],
            'hero_image'       => $heroImage    ? [$heroImage]    : [],
            'contact_image'    => $contactImage ? [$contactImage] : [],
            'portfolio_images' => $portfolio,
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Основное')
                ->schema([
                    FileUpload::make('logo')
                        ->label('Логотип')
                        ->disk('public_root')
                        ->directory('images')
                        ->image()
                        ->imageEditor()
                        ->imagePreviewHeight('120'),

                    FileUpload::make('hero_image')
                        ->label('Фон главного баннера')
                        ->disk('public_root')
                        ->directory('images')
                        ->image()
                        ->imageEditor()
                        ->imagePreviewHeight('120'),

                    FileUpload::make('contact_image')
                        ->label('Картинка в блоке контактов')
                        ->disk('public_root')
                        ->directory('images')
                        ->image()
                        ->imageEditor()
                        ->imagePreviewHeight('120'),
                ]),

            Section::make('Примеры работ')
                ->description('Фотографии отображаются в галерее на главной странице.')
                ->schema([
                    Repeater::make('portfolio_images')
                        ->label('Фотографии')
                        ->schema([
                            FileUpload::make('path')
                                ->label('Фото')
                                ->disk('public_root')
                                ->directory('images/portfolio')
                                ->image()
                                ->imageEditor()
                                ->imagePreviewHeight('120')
                                ->required()
                                ->columnSpanFull(),
                            TextInput::make('alt')
                                ->label('Alt текст')
                                ->placeholder('Описание фото для поисковиков')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Добавить фото')
                        ->columns(1)
                        ->reorderable()
                        ->collapsible(),
                ]),
        ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([$this->getSaveFormAction()])
                        ->key('form-actions'),
                ]),
        ]);
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Сохранить')
            ->submit('save');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $logoFiles = $data['logo'] ?? null;
        $logo = is_array($logoFiles) ? ($logoFiles[0] ?? null) : $logoFiles;

        $heroFiles = $data['hero_image'] ?? null;
        $heroImage = is_array($heroFiles) ? ($heroFiles[0] ?? null) : $heroFiles;

        $contactFiles = $data['contact_image'] ?? null;
        $contactImage = is_array($contactFiles) ? ($contactFiles[0] ?? null) : $contactFiles;

        Setting::set('logo', $logo);
        Setting::set('hero_image', $heroImage);
        Setting::set('contact_image', $contactImage);
        cache()->forget('settings_all');

        // Синхронизируем портфолио
        Image::where('type', 'portfolio')->delete();
        foreach ($data['portfolio_images'] ?? [] as $item) {
            $paths = $item['path'] ?? null;
            $path  = is_array($paths) ? ($paths[0] ?? null) : $paths;
            if ($path) {
                Image::create([
                    'path' => $path,
                    'alt'  => $item['alt'] ?? null,
                    'type' => 'portfolio',
                ]);
            }
        }
        cache()->forget('portfolio_images');

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }
}
