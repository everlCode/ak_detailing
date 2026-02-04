<?php echo '<?xml version="1.0" encoding="UTF-8"?>\n'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($items as $it)
  <url>
    <loc>{{ $it['loc'] }}</loc>
    <lastmod>{{ $it['lastmod'] }}</lastmod>
    <changefreq>{{ $it['changefreq'] }}</changefreq>
    <priority>{{ $it['priority'] }}</priority>
  </url>
@endforeach
</urlset>
