<?php

namespace App\Filament\Resources\PortfolioCases\Pages;

use App\Filament\Resources\PortfolioCases\PortfolioCaseResource;
use App\Models\Image;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPortfolioCase extends EditRecord
{
    protected static string $resource = PortfolioCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->label('Просмотр'),
            DeleteAction::make()->label('Удалить'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['caseImages'] = $this->record->images
            ->map(fn (Image $img) => [
                'path' => [$img->path],
                'alt'  => $img->alt ?? '',
            ])
            ->toArray();

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->images()->delete();

        foreach ($this->form->getState()['caseImages'] ?? [] as $item) {
            $paths = $item['path'] ?? null;
            $path  = is_array($paths) ? ($paths[0] ?? null) : $paths;

            if ($path) {
                Image::create([
                    'path'         => $path,
                    'alt'          => $item['alt'] ?? null,
                    'type'         => 'portfolio_case',
                    'reference_id' => $this->record->id,
                ]);
            }
        }

        cache()->forget('portfolio_cases_index');
        cache()->forget('portfolio_cases_slider');
    }
}
