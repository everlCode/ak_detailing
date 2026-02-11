<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('main_image')
                    ->label('Главное изображение')
                    ->disk('public_root')
                    ->image()
                    ->imageEditor()
                    ->directory(fn ($record, $get) =>
                        'images/services/' . \Illuminate\Support\Str::slug(
                            $record?->alias ?? $get('alias') ?? 'service'
                        )
                    )
                    ->multiple(false),

                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('р.'),
                TextInput::make('alias')
                    ->required(),
                RichEditor::make('description')
                    ->columnSpanFull(),
                Textarea::make('short_description')
                    ->columnSpanFull(),
            ]);
    }
}
