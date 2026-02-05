<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Добавляем запись vk_link в таблицу settings, если её ещё нет
        DB::table('settings')->updateOrInsert(
            ['key' => 'vk_link'],
            ['value' => 'https://vk.com/detailing_kirov', 'updated_at' => now(), 'created_at' => now()]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->where('key', 'vk_link')->delete();
    }
};
