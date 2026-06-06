<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Название'),
                TextEntry::make('price')
                    ->label('Цена')
                    ->money('RUB'),
                TextEntry::make('alias')
                    ->label('Алиас'),
                TextEntry::make('description')
                    ->label('Описание')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('short_description')
                    ->label('Краткое описание')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
