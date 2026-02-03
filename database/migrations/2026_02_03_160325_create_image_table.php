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
        Schema::create('images', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->string('path'); // путь к файлу относительно /uploads
            $table->string('alt')->nullable(); // текст alt
            $table->string('title')->nullable(); // название / подпись
            $table->string('type', 50)->nullable(); // тип: banner, page, avatar...
            $table->unsignedBigInteger('reference_id')->nullable(); // id связанной сущности
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
