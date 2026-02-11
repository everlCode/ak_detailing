<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($this->record->mainImage?->path) {
            $data['main_image'] = [
                $this->record->mainImage->path
            ];
        }

        return $data;
    }

    protected function afterSave(): void
    {
        \Log::info('=== afterSave START ===');

        // 1️⃣ Посмотрим, что вообще в состоянии формы
        $formState = $this->form->getState();
        \Log::info('Form state', $formState);

        // 2️⃣ Получаем main_image
        $files = $formState['main_image'] ?? null;
        \Log::info('Raw main_image from state', ['files' => $files]);

        // 3️⃣ Если массив, берём первый элемент
        $file = is_array($files) ? ($files[0] ?? null) : $files;
        \Log::info('File to save', ['file' => $file]);

        // 4️⃣ Проверяем, есть ли файл
        if ($file) {
            $this->record->mainImage()->updateOrCreate(
                ['type' => 'main'],
                [
                    'path' => $file,
                    'type' => 'main',
                ]
            );
            \Log::info('Image saved to DB', ['path' => $file]);
        } else {
            \Log::warning('No file found to save');
        }

        // 5️⃣ Очистка кеша
        $alias = $this->record->alias;
        $cachePath = public_path("cache/images/services/{$alias}");
        \Log::info('Cache path', ['path' => $cachePath]);

        \Log::info('Cache files in directory', ['files' => \File::files($cachePath)]);

        if (\File::exists($cachePath)) {
            $files = \File::files($cachePath);
            foreach ($files as $file) {
                \File::delete($file);
            }
            \Log::info('Cache files deleted', ['files_count' => count($files)]);
        } else {
            \Log::info('Cache directory does not exist', ['path' => $cachePath]);
        }
        \Artisan::call('cache:clear');
        \Log::info('=== afterSave END ===');
    }


}
