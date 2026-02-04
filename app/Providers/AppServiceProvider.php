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

        View::composer('partials.header', function ($view) {
            try {
                $services = cache()->remember('settings_all', 60 * 60 * 24, function () {
                    return Service::orderBy('name')->get();
                });
            } catch (\Throwable $e) {
                // В случае ошибки при получении — передаём пустую коллекцию
                $services = collect();
            }

            $view->with('services', $services);
        });
    }
}
