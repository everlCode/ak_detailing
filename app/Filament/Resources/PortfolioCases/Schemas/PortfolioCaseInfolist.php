<?php

namespace App\Filament\Resources\PortfolioCases\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PortfolioCaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')->label('Заголовок'),
                TextEntry::make('slug')->label('Slug'),
                TextEntry::make('car_make')->label('Марка'),
                TextEntry::make('car_model')->label('Модель'),
TextEntry::make('service.name')->label('Услуга')->placeholder('—'),
                TextEntry::make('description')->label('Описание')->placeholder('—')->columnSpanFull(),
                TextEntry::make('meta_description')->label('Meta Description')->placeholder('—')->columnSpanFull(),
                TextEntry::make('created_at')->label('Создано')->dateTime()->placeholder('—'),
                TextEntry::make('updated_at')->label('Обновлено')->dateTime()->placeholder('—'),
            ]);
    }
}
