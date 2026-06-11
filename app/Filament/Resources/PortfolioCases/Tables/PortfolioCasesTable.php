<?php

namespace App\Filament\Resources\PortfolioCases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PortfolioCasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('car_make')
                    ->label('Марка')
                    ->searchable(),
                TextColumn::make('car_model')
                    ->label('Модель')
                    ->searchable(),
                TextColumn::make('car_year')
                    ->label('Год')
                    ->sortable(),
                TextColumn::make('service.name')
                    ->label('Услуга')
                    ->placeholder('—'),
                TextColumn::make('views')
                    ->label('Просмотры')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
