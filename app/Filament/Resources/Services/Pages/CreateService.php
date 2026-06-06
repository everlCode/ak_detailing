<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Models\Image;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function afterCreate(): void
    {
        $formState = $this->form->getState();

        // Сохранение главного изображения
        $mainFiles = $formState['main_image'] ?? null;
        $mainFile = is_array($mainFiles) ? ($mainFiles[0] ?? null) : $mainFiles;

        if ($mainFile) {
            $this->record->mainImage()->create([
                'path' => $mainFile,
                'type' => 'main',
            ]);
        }

        // Сохранение примеров работ
        foreach ($formState['exampleImages'] ?? [] as $item) {
            $paths = $item['path'] ?? null;
            $path = is_array($paths) ? ($paths[0] ?? null) : $paths;

            if ($path) {
                Image::create([
                    'path'         => $path,
                    'alt'          => $item['alt'] ?? null,
                    'type'         => 'example',
                    'reference_id' => $this->record->id,
                ]);
            }
        }
    }
}
