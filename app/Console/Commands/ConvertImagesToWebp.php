<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:to-webp';
    protected $description = 'Convert all images in public/images/services (recursively) to WebP';

    public function handle()
    {
        $sourceDir = public_path('images/services');

        if (!is_dir($sourceDir)) {
            $this->error('Directory not found: ' . $sourceDir);
            return Command::FAILURE;
        }

        $manager = new ImageManager(new Driver());

        // рекурсивно обходим папки
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && preg_match('/\.(jpg|jpeg|png)$/i', $file->getFilename())) {
                $filePath = $file->getPathname();
                $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $filePath);

                // если webp уже есть — пропускаем
                if (file_exists($webpPath)) {
                    $this->line('Skip: ' . $filePath);
                    continue;
                }

                try {
                    $manager
                        ->read($filePath)
                        ->resize(1200, null, function ($c) {
                            $c->aspectRatio();
                            $c->upsize();
                        })
                        ->toWebp(75)
                        ->save($webpPath);

                    $this->info('Converted: ' . $filePath);

                    // ❗ если нужно удалить оригинал — раскомментируй
                    // unlink($filePath);

                } catch (\Throwable $e) {
                    $this->error('Error with ' . $filePath . ': ' . $e->getMessage());
                }
            }
        }

        $this->info('Done 🎉');
        return Command::SUCCESS;
    }
}
