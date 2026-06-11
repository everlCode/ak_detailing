<?php

namespace App\Http\Controllers;

use App\Models\PortfolioCase;
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

        $metaDesc = $service->meta_description
            ?: $service->short_description
            ?: "{$service->name} в Кирове — профессиональный детейлинг от A.K Detailing. Запись онлайн.";

        view()->share('metaDescription', $metaDesc);

        if ($service->mainImage?->path) {
            view()->share('ogImage', asset($service->mainImage->path));
        }

        $cases = PortfolioCase::with('mainImage')
            ->where('service_id', $service->id)
            ->orderByDesc('views')
            ->orderByDesc('id')
            ->get();

        return view('services.show', ['service' => $service, 'cases' => $cases]);
    }
}
