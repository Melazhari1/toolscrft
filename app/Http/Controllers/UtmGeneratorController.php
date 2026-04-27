<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class UtmGeneratorController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/UtmGenerator', [
            'seo' => $this->generateSeo(
                'Campaign URL Builder - UTM Generator',
                'Easily add UTM parameters to your URLs to track your marketing campaigns in Google Analytics.'
            ),
            'tools' => $this->getTools(),
            'currentTool' => 'utm-generator.index'
        ]);
    }
}
