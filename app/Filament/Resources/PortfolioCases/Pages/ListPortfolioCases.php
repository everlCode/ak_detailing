<?php

namespace App\Filament\Resources\PortfolioCases\Pages;

use App\Filament\Resources\PortfolioCases\PortfolioCaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPortfolioCases extends ListRecords
{
    protected static string $resource = PortfolioCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить кейс'),
        ];
    }
}
