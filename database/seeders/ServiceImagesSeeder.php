<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;

class ServiceImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Путь к общему placeholder'у
        $placeholder = public_path('images/car.jpg');

        $now = now();

        Service::chunk(50, function ($services) use ($placeholder, $now) {
            foreach ($services as $service) {
                $alias = $service->alias ?: 'service-' . $service->id;
                $dir = public_path("images/services/{$alias}");

                if (!is_dir($dir)) {
                    @mkdir($dir, 0755, true);
                }

                // Файлы, которые мы хотим создать
                $files = [
                    ['name' => 'main.jpeg', 'type' => 'main'],
                    ['name' => 'example1.jpeg', 'type' => 'example'],
                    ['name' => 'example2.jpeg', 'type' => 'example'],
                ];

                $inserts = [];

                foreach ($files as $f) {
                    $target = $dir . DIRECTORY_SEPARATOR . $f['name'];
                    $webPath = "images/services/{$alias}/" . $f['name'];
                    // Копируем placeholder, если целевого файла ещё нет
                    if (!file_exists($target) && file_exists($placeholder)) {
                        copy($placeholder, $target);
                    }

                    // Создаём запись в таблице images, если для этого reference_id/type/path ещё нет
                    $exists = DB::table('images')
                        ->where('reference_id', $service->id)
                        ->where('type', $f['type'])
                        ->where('path', $webPath)
                        ->exists();

                    if (!$exists) {
                        $inserts[] = [
                            'path' => $webPath,
                            'alt' => $service->name,
                            'title' => $service->name,
                            'type' => $f['type'],
                            'reference_id' => $service->id,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }

                if (!empty($inserts)) {
                    DB::table('images')->insert($inserts);
                }
            }
        });
    }
}
