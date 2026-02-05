<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Service;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Регистрируйте тут сервисы приложения.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Не выполняем при запуске из консоли (artisan), чтобы избежать лишних DB-запросов в задачах
        if ($this->app->runningInConsole()) {
            return;
        }

        // Передаём services и settings в header и footer
        View::composer(['partials.header', 'partials.footer', 'partials.contact-block', 'partials.booking-modal'], function ($view) {
            try {
                $services = cache()->remember('service_all', 60 * 60 * 24, function () {
                    return Service::all();
                });
            } catch (\Throwable $e) {
                // В случае ошибки при получении — передаём пустую коллекцию
                $services = collect();
            }

            try {
                // Гарантируем, что в $settings попадёт чистый ассоциативный массив key => value,
                // а не коллекция моделей (это важно для простого вывода в представлениях).
                $settings = cache()->remember('settings_all', 60 * 60 * 24, function () {
                    return Setting::all()
                        ->mapWithKeys(function ($item) {
                            return [$item->key => $item->value];
                        })
                        ->toArray();
                });

                // На всякий случай — если в кеше что-то было не в виде массива, приводим тип
                if (is_object($settings) || $settings instanceof \Illuminate\Support\Collection) {
                    $settings = (array) $settings;
                }
            } catch (\Throwable $e) {
                $settings = [];
            }

            $view->with('services', $services)->with('settings', $settings);
        });
    }
}
