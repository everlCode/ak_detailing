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
        // Добавляем колонку только если её ещё нет — безопасно при повторных запусках
        if (!Schema::hasColumn('services', 'short_description')) {
            Schema::table('services', function (Blueprint $table) {
                $table->text('short_description')->nullable()->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('services', 'short_description')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('short_description');
            });
        }
    }
};
