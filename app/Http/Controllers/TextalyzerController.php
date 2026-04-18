<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class TextalyzerController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/Textalyzer', [
            'seo' => $this->generateSeo('Textalyzer keyword density and word count tool', 'Analyze text instantly with keyword density, word count, sentence metrics, and readability insights for writers, SEOs, and content editors on the fly.'),
            'tools' => $this->getTools(),
            'currentTool' => 'textalyzer.index'
        ]);
    }
}
