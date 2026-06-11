<?php

namespace App\Filament\Resources\PortfolioCases\Schemas;

use App\Models\Service;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PortfolioCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('CaseTabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Основное')
                            ->schema([
                                TextInput::make('car_make')
                                    ->label('Марка авто')
                                    ->required(),

                                TextInput::make('car_model')
                                    ->label('Модель авто')
                                    ->required(),

                                TextInput::make('car_year')
                                    ->label('Год выпуска')
                                    ->numeric()
                                    ->minValue(1990)
                                    ->maxValue((int) date('Y')),

                                Select::make('service_id')
                                    ->label('Услуга')
                                    ->options(Service::pluck('name', 'id'))
                                    ->searchable()
                                    ->nullable(),

                                RichEditor::make('description')
                                    ->label('Описание кейса')
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Фотографии')
                            ->schema([
                                Repeater::make('caseImages')
                                    ->label('Фотографии')
                                    ->schema([
                                        FileUpload::make('path')
                                            ->label('Фото')
                                            ->disk('public_root')
                                            ->image()
                                            ->imageEditor()
                                            ->imagePreviewHeight('120')
                                            ->directory(fn ($record) =>
                                                'images/portfolio/' . ($record?->slug ?? 'case')
                                            )
                                            ->required()
                                            ->columnSpanFull(),

                                        TextInput::make('alt')
                                            ->label('Alt текст')
                                            ->placeholder('Например: Полировка BMW E46 — результат')
                                            ->required()
                                            ->columnSpanFull(),
                                    ])
                                    ->addActionLabel('Добавить фото')
                                    ->columns(1),
                            ]),

                        Tab::make('SEO')
                            ->schema([
                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->placeholder('До 160 символов')
                                    ->maxLength(160)
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
