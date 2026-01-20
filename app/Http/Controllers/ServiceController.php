<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

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
        $service = Service::where('alias', $alias)->firstOrFail();

        return view('services.show', [
            'service' => $service,
        ]);
    }
}

