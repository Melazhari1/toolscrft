<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class UrlEncoderController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/UrlEncoder', [
            'seo' => $this->generateSeo('URL encode and decode strings for web development', 'Encode and decode URLs, query strings, and special characters for safe web transmission and API integration.')
        ]);
    }
}
