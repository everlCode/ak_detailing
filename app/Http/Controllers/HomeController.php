<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
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

        $settings = Cache::remember('settings', now()->addHours(6), function () {
            return Setting::all();
        });
        view()->share('metaDescription', 'Детейлинг услуги в Кирове. Быстро, качественно и недорого.');
        return view('home', ['services' => $services, 'settings' => $settings]);
    }
}
