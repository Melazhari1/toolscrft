<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    protected function generateSeo($title, $description, array $geo = [], $aeo = null)
    {
        return [
            'title' => $title . ' - ToolsCraft',
            'description' => $description,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebApplication',
                'name' => $title,
                'description' => $description,
                'url' => url()->current()
            ],
            'geo' => $geo,
            'aeo' => $aeo,
        ];
    }

    protected function getTools()
    {
        return [
            ['name' => 'Textalyzer', 'slug' => 'textalyzer.index', 'desc' => 'Word count & keyword density'],
            ['name' => 'Domain Expiry', 'slug' => 'domain-expiry.index', 'desc' => 'Check domain expiration dates'],
            ['name' => 'Whois Lookup', 'slug' => 'domain-whois.index', 'desc' => 'Domain registration data'],
            ['name' => 'Lorem Ipsum', 'slug' => 'lorem-ipsum.index', 'desc' => 'JS text generator'],
            ['name' => 'JSON to CSV', 'slug' => 'json-to-csv.index', 'desc' => 'JSON to CSV file conversion'],
            ['name' => 'CSV to JSON', 'slug' => 'csv-to-json.index', 'desc' => 'CSV to JSON conversion'],
            ['name' => 'URL Encoder', 'slug' => 'url-encoder.index', 'desc' => 'Encode/decode URLs'],
            ['name' => 'CSS Minifier', 'slug' => 'css-minifier.index', 'desc' => 'Compress or format CSS'],
            ['name' => 'Gradient Tool', 'slug' => 'css-gradient.index', 'desc' => 'Visual CSS gradient generator'],
            ['name' => 'Slug Generator', 'slug' => 'slug-generator.index', 'desc' => 'SEO-friendly URL slugs'],
            ['name' => 'UTM Builder', 'slug' => 'utm-generator.index', 'desc' => 'Campaign URL builder']
        ];
    }
}
