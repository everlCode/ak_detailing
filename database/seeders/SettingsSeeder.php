<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(['key' => 'phone'], ['value' => '+7 700 123-45-67']);
        Setting::updateOrCreate(['key' => 'telegram'], ['value' => '@your_telegram']);
        Setting::updateOrCreate(['key' => 'address'], ['value' => 'г. Алматы, ул. Примерная, 10']);
    }
}
