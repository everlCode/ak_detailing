<?php

namespace App\Filament\Resources\PortfolioCases\Pages;

use App\Filament\Resources\PortfolioCases\PortfolioCaseResource;
use App\Models\Image;
use App\Models\PortfolioCase;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePortfolioCase extends CreateRecord
{
    protected static string $resource = PortfolioCaseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $base = Str::slug(collect([$data['car_make'] ?? '', $data['car_model'] ?? ''])->filter()->implode(' '));
        $slug = $base;
        $i = 1;
        while (PortfolioCase::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        $data['slug'] = $slug;
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->syncImages($this->form->getState());
        cache()->forget('portfolio_cases_index');
        cache()->forget('portfolio_cases_slider');
    }

    protected function syncImages(array $formState): void
    {
        foreach ($formState['caseImages'] ?? [] as $item) {
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
    }
}
