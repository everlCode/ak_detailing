<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_cases', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_cases', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};
