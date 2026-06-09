<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display the specified service by alias.
     *
     * @param  string  $alias
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $alias)
    {
        $service = Service::with(['mainImage', 'exampleImages'])
            ->where('alias', $alias)
            ->firstOrFail();

        view()->share('metaDescription', $service->meta_description ?: $service->short_description);

        return view('services.show', ['service' => $service]);
    }
}
