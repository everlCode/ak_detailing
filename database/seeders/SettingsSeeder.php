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
        Setting::updateOrCreate(['key' => 'phone'], ['value' => '+79195144711']);
        Setting::updateOrCreate(['key' => 'telegram'], ['value' => '@ak_detailing43']);
        Setting::updateOrCreate(['key' => 'address'], ['value' => 'г. Киров, Автотранспортный переулок, 4ж']);
        // Координаты карты: формат "lat,lon"
        Setting::updateOrCreate(['key' => 'map_coords'], ['value' => '58.578203, 49.670062']);
        // Почты для уведомлений о заявках (через запятую)
        Setting::updateOrCreate(['key' => 'booking_emails'], ['value' => 'kolukul1996@gmail.com, andrey.kylak.98@mail.ru']);
        // Ссылка на группу ВКонтакте
        Setting::updateOrCreate(['key' => 'vk_link'], ['value' => 'https://vk.com/detailing_kirov']);
    }
}
