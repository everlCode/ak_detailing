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
        // Координаты карты: формат "lat,lon"
        Setting::updateOrCreate(['key' => 'map_coords'], ['value' => '43.238949,76.889709']);
        // Почты для уведомлений о заявках (через запятую)
        Setting::updateOrCreate(['key' => 'booking_emails'], ['value' => 'admin@example.com']);
        // Ссылка на группу ВКонтакте
        Setting::updateOrCreate(['key' => 'vk_link'], ['value' => 'https://vk.com/your_group']);
    }
}
