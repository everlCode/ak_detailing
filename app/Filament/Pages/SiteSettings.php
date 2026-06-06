<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Настройки';

    protected static ?string $title = 'Настройки сайта';

    protected static ?int $navigationSort = 10;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'phone'          => Setting::get('phone'),
            'telegram'       => Setting::get('telegram'),
            'vk_link'        => Setting::get('vk_link'),
            'address'        => Setting::get('address'),
            'booking_emails' => Setting::get('booking_emails'),
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('phone')
                ->label('Телефон')
                ->placeholder('+7 000 000 00 00')
                ->tel(),

            TextInput::make('telegram')
                ->label('Telegram')
                ->placeholder('@username'),

            TextInput::make('vk_link')
                ->label('ВКонтакте')
                ->placeholder('https://vk.com/...'),

            TextInput::make('address')
                ->label('Адрес')
                ->placeholder('г. Город, ул. Улица, д. 1'),

            TextInput::make('booking_emails')
                ->label('Email для заявок')
                ->placeholder('email@example.com')
                ->helperText('Несколько адресов — через запятую'),
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

        foreach (['phone', 'telegram', 'vk_link', 'address', 'booking_emails'] as $key) {
            Setting::set($key, $data[$key] ?? null);
        }

        cache()->forget('settings_all');

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }
}
