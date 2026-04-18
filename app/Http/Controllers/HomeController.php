<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'seo' => $this->generateSeo('Professional local SEO tools and data utilities', 'Access a suite of privacy-focused SEO and developer utilities for text analysis, domain data, placeholder text, and JSON conversion in a fast local interface.'),
            'tools' => [
                ['name' => 'Textalyzer', 'slug' => 'textalyzer.index', 'desc' => 'Word count & keyword density'],
                ['name' => 'Domain Expiry', 'slug' => 'domain-expiry.index', 'desc' => 'Check domain expiration dates'],
                ['name' => 'Whois Lookup', 'slug' => 'domain-whois.index', 'desc' => 'Domain registration data'],
                ['name' => 'Lorem Ipsum', 'slug' => 'lorem-ipsum.index', 'desc' => 'JS text generator'],
                ['name' => 'JSON to CSV', 'slug' => 'json-to-csv.index', 'desc' => 'JSON to CSV file conversion'],
                ['name' => 'CSV to JSON', 'slug' => 'csv-to-json.index', 'desc' => 'CSV to JSON conversion'],
                ['name' => 'URL Encoder', 'slug' => 'url-encoder.index', 'desc' => 'Encode/decode URLs']
            ]
        ]);
    }
}
