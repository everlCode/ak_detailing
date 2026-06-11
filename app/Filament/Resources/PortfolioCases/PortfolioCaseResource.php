<?php

namespace App\Filament\Resources\PortfolioCases;

use App\Filament\Resources\PortfolioCases\Pages\CreatePortfolioCase;
use App\Filament\Resources\PortfolioCases\Pages\EditPortfolioCase;
use App\Filament\Resources\PortfolioCases\Pages\ListPortfolioCases;
use App\Filament\Resources\PortfolioCases\Pages\ViewPortfolioCase;
use App\Filament\Resources\PortfolioCases\Schemas\PortfolioCaseForm;
use App\Filament\Resources\PortfolioCases\Schemas\PortfolioCaseInfolist;
use App\Filament\Resources\PortfolioCases\Tables\PortfolioCasesTable;
use App\Models\PortfolioCase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PortfolioCaseResource extends Resource
{
    protected static ?string $model = PortfolioCase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Наши работы';
    protected static ?string $modelLabel = 'Кейс';
    protected static ?string $pluralModelLabel = 'Наши работы';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PortfolioCaseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PortfolioCaseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortfolioCasesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPortfolioCases::route('/'),
            'create' => CreatePortfolioCase::route('/create'),
            'view'   => ViewPortfolioCase::route('/{record}'),
            'edit'   => EditPortfolioCase::route('/{record}/edit'),
        ];
    }
}
