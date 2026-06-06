<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Models\Image;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\File;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->label('Просмотр'),
            DeleteAction::make()->label('Удалить'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($this->record->mainImage?->path) {
            $data['main_image'] = [$this->record->mainImage->path];
        }

        $data['exampleImages'] = $this->record->exampleImages
            ->map(fn (Image $img) => [
                'path' => [$img->path],
                'alt'  => $img->alt ?? '',
            ])
            ->toArray();

        return $data;
    }

    protected function afterSave(): void
    {
        $formState = $this->form->getState();
        \Log::debug('afterSave formState', $formState);

        // Сохранение главного изображения
        $mainFiles = $formState['main_image'] ?? null;
        $mainFile = is_array($mainFiles) ? ($mainFiles[0] ?? null) : $mainFiles;

        if ($mainFile) {
            $this->record->mainImage()->updateOrCreate(
                ['type' => 'main'],
                ['path' => $mainFile, 'type' => 'main'],
            );
        }

        // Синхронизация примеров работ: удаляем старые, создаём из формы
        $this->record->exampleImages()->delete();

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

        // Очистка кеша изображений
        $cachePath = public_path("cache/images/services/{$this->record->alias}");

        if (File::exists($cachePath)) {
            foreach (File::files($cachePath) as $file) {
                File::delete($file);
            }
        }

        \Artisan::call('cache:clear');
    }


}
