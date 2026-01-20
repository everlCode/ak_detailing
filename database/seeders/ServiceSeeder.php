<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::updateOrCreate([
            'alias' => 'polirovka-komplekt'
        ], [
            'name' => 'Полировка (комплект)',
            'price' => 7500.00,
            'description' => "Глубокая полировка кузова, удаление мелких дефектов и восстановление блеска.\nВключает химчистку и защитное покрытие.",
        ]);

        Service::updateOrCreate([
            'alias' => 'kuzovnoy-remont'
        ], [
            'name' => 'Кузовной ремонт',
            'price' => 25000.00,
            'description' => "Ремонт вмятин, выравнивание и покраска отдельных элементов кузова.",
        ]);
    }
}

