<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $images = DB::table('images')
            ->where(function ($query) {
                $query->where('path', 'like', '%.jpg')
                    ->orWhere('path', 'like', '%.jpeg')
                    ->orWhere('path', 'like', '%.png');
            })
            ->get();

        foreach ($images as $image) {
            $newPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image->path);

            DB::table('images')
                ->where('id', $image->id)
                ->update(['path' => $newPath]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // На откат просто возвращаем jpg
        $images = DB::table('images')
            ->where('path', 'like', '%.webp')
            ->get();

        foreach ($images as $image) {
            // На откат можно выбрать конкретный формат (например jpg)
            $newPath = preg_replace('/\.webp$/i', '.jpg', $image->path);

            DB::table('images')
                ->where('id', $image->id)
                ->update(['path' => $newPath]);
        }
    }
};
