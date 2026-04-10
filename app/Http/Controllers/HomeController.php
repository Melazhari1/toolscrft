<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'seo' => $this->generateSeo('Ultimate Tools Suite', 'Collection of professional utility tools.'),
            'tools' => [
                ['name' => 'Textalyzer', 'slug' => 'textalyzer.index', 'desc' => 'Word count & keyword density'],
                ['name' => 'Domain Expiry', 'slug' => 'domain-expiry.index', 'desc' => 'Check domain expiration dates'],
                ['name' => 'Whois Lookup', 'slug' => 'domain-whois.index', 'desc' => 'Domain registration data'],
                ['name' => 'Lorem Ipsum', 'slug' => 'lorem-ipsum.index', 'desc' => 'JS text generator'],
                ['name' => 'JSON to CSV', 'slug' => 'json-to-csv.index', 'desc' => 'JSON to CSV file conversion']
            ]
        ]);
    }
}
