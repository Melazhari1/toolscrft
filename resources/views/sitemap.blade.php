<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $url)
  <url>
    <loc>{{ $url['loc'] }}</loc>
    <lastmod>{{ $lastMod }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>{{ $url['priority'] }}</priority>
  </url>
@endforeach
</urlset>
