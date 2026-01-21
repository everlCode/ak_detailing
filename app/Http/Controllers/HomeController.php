<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the main page with services.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $services = Service::all();
        return view('home', compact('services'));
    }
}
