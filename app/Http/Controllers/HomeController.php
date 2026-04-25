<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'seo' => $this->generateSeo('Professional local SEO tools and data utilities', 'Access a suite of privacy-focused SEO and developer utilities for text analysis, domain data, placeholder text, and JSON conversion in a fast local interface.'),
            'tools' => $this->getTools()
        ]);
    }
}
