<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_cases', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('car_make');
            $table->string('car_model');
            $table->unsignedSmallInteger('car_year')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_cases');
    }
};
