<?php

namespace App\Filament\Resources\PortfolioCases\Pages;

use App\Filament\Resources\PortfolioCases\PortfolioCaseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPortfolioCase extends ViewRecord
{
    protected static string $resource = PortfolioCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->label('Редактировать'),
        ];
    }
}
