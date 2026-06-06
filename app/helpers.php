<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

function img(string $path, int $w, int $h): string
{
    $publicPath = public_path($path);

    // если оригинала нет — просто отдаем как есть
    if (!file_exists($publicPath)) {
        return asset($path);
    }

    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    // SVG не обрабатываем
    if ($ext === 'svg') {
        return asset($path);
    }

    $dir  = trim(dirname($path), '.'); // images/services
    $name = pathinfo($path, PATHINFO_FILENAME);

    // путь кеша с сохранением структуры
    $cacheDirRel = "cache/{$dir}";
    $cacheDirAbs = public_path($cacheDirRel);

    $cachedRel = "{$cacheDirRel}/{$w}x{$h}_{$name}.{$ext}";
    $cachedAbs = public_path($cachedRel);

    // если уже есть — отдаем
    if (file_exists($cachedAbs)) {
        return asset($cachedRel);
    }

    // создаем директорию рекурсивно
    if (!is_dir($cacheDirAbs)) {
        mkdir($cacheDirAbs, 0755, true);
    }

    try {
        $manager = new ImageManager(new Driver());

        $image = $manager
            ->read($publicPath)
            ->cover($w, $h)
            ->toWebp(82);

        file_put_contents($cachedAbs, (string) $image);

        return asset($cachedRel);

    } catch (\Throwable $e) {
        // fallback — оригинал
        return asset($path);
    }
}

