<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContactsController extends Controller
{
    /**
     * Показывает страницу контактов
     */
    public function index()
    {
        $services = Cache::remember('services_with_main_image', now()->addHours(6), function () {
            return Service::with('mainImage')->get();
        });
        $settings = cache()->remember('settings_all', 60 * 60 * 24, function () {
            return Setting::all()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })
                ->toArray();
        });

        return view('contacts', ['settings' => $settings, 'services' => $services]);
    }
}
