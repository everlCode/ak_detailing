<?php

namespace App\Http\Controllers;

use App\Models\PortfolioCase;
use Illuminate\Support\Facades\Cache;

class PortfolioCaseController extends Controller
{
    public function index()
    {
        $cases = Cache::remember('portfolio_cases_index', now()->addHours(6), function () {
            return PortfolioCase::with(['mainImage', 'service'])->latest()->get();
        });

        return view('portfolio.index', ['cases' => $cases]);
    }

    public function show(string $slug)
    {
        $case = PortfolioCase::with(['images', 'service'])
            ->where('slug', $slug)
            ->firstOrFail();

        $case->incrementQuietly('views');
        cache()->forget('portfolio_cases_slider');

        return view('portfolio.show', ['case' => $case]);
    }
}
