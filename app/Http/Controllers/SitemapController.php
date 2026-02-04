<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        $base = rtrim(config('app.url') ?: url('/'), '/');

        $services = Service::select('alias', 'updated_at')->get();

        $items = [];
        // Главная и контакты
        $now = now()->toAtomString();
        $items[] = ['loc' => $base . '/', 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '1.0'];
        $items[] = ['loc' => $base . '/contacts', 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.6'];

        foreach ($services as $s) {
            $items[] = [
                'loc' => $base . '/services/' . $s->alias,
                'lastmod' => optional($s->updated_at)->toAtomString() ?: $now,
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ];
        }

        // Собираем XML через DOMDocument, чтобы исключить лишние байты/пробелы перед декларацией
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $dom->appendChild($urlset);

        foreach ($items as $it) {
            $url = $dom->createElement('url');

            $loc = $dom->createElement('loc', htmlspecialchars($it['loc'], ENT_XML1 | ENT_COMPAT, 'UTF-8'));
            $url->appendChild($loc);

            $last = $dom->createElement('lastmod', $it['lastmod']);
            $url->appendChild($last);

            $cf = $dom->createElement('changefreq', $it['changefreq']);
            $url->appendChild($cf);

            $pr = $dom->createElement('priority', $it['priority']);
            $url->appendChild($pr);

            $urlset->appendChild($url);
        }

        $xml = $dom->saveXML();

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
