<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class TextalyzerController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/Textalyzer', [
            'seo' => $this->generateSeo('Textalyzer', 'Analyze word count and keyword density.')
        ]);
    }
}
