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
        //
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

        // Композер представления: подставляем $services в partial header на всех страницах
        View::composer('partials.header', function ($view) {
            try {
                $services = Service::orderBy('name')->get();
            } catch (\Throwable $e) {
                // В случае ошибки при получении — передаём пустую коллекцию
                $services = collect();
            }

            $view->with('services', $services);
        });

        // Загрузка настроек в глобальную переменную для view
        View::composer('*', function ($view) {
            try {
                $rows = Setting::all();
                $settings = [];
                foreach ($rows as $row) {
                    $settings[$row->key] = $row->value;
                }
            } catch (\Throwable $e) {
                $settings = [];
            }

            $view->with('settings', $settings);
        });
    }
}
