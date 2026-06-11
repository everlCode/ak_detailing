<?php

namespace App\Http\Controllers;

use App\Models\PortfolioCase;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the main page with services.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $services = Cache::remember('services_with_main_image', now()->addHours(6), function () {
            return Service::with('mainImage')->get();
        });

        $settings = Cache::remember('settings_all', 60 * 60 * 24, function () {
            return Setting::all()
                ->mapWithKeys(fn ($item) => [$item->key => $item->value])
                ->toArray();
        });
        $portfolio = Cache::remember('portfolio_cases_slider', now()->addHours(6), function () {
            return PortfolioCase::with(['mainImage', 'service'])
                ->orderByDesc('views')
                ->orderByDesc('id')
                ->get();
        });

        view()->share('metaDescription', 'Профессиональные детейлинг услуги в Кирове: химчистка салона, полировка кузова, керамика. Район Чистых прудов. Запись онлайн.');

        return view('home', ['services' => $services, 'settings' => $settings, 'portfolio' => $portfolio]);
    }
}
