<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_cases', function (Blueprint $table) {
            $table->dropColumn('car_year');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_cases', function (Blueprint $table) {
            $table->unsignedSmallInteger('car_year')->nullable()->after('car_model');
        });
    }
};
