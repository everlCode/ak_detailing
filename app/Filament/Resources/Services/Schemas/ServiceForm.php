<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('ServiceTabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Основное')
                            ->schema([
                                FileUpload::make('main_image')
                                    ->label('Главное изображение')
                                    ->disk('public_root')
                                    ->image()
                                    ->imageEditor()
                                    ->directory(fn ($record, $get) =>
                                        'images/services/' . Str::slug($record?->alias ?? $get('alias') ?? 'service')
                                    )
                                    ->multiple(false),

                                TextInput::make('name')->required(),
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->default(0.0)
                                    ->prefix('р.'),
                                TextInput::make('alias')->required(),
                                RichEditor::make('description')->columnSpanFull(),
                                Textarea::make('short_description')->columnSpanFull(),
                            ]),

                        Tab::make('Примеры работ')
                            ->schema([
                                Repeater::make('exampleImages')
                                    ->label('Примеры работ')
                                    ->relationship('exampleImages')
                                    ->schema([
                                        FileUpload::make('path')
                                            ->label('Фото')
                                            ->disk('public_root')
                                            ->image()
                                            ->imageEditor()
                                            ->directory(fn ($record, $get) =>
                                                'images/services/' . Str::slug($record?->alias ?? $get('alias') ?? 'service') . '/examples'
                                            )
                                            ->required(),
                                    ])
                                    ->createItemButtonLabel('Добавить фото')
                                    ->columns(1)
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $get) {
                                        $name = $get('name') ?? 'Service';
                                        return [
                                            ...$data,
                                            'alt'   => $name,
                                            'title' => $name,
                                            'type'  => 'example',
                                        ];
                                    }),
                            ]),
                    ]),
            ]); // <--- важно поставить точку с запятой
    }
}
