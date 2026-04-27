<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SlugGeneratorController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/SlugGenerator', [
            'seo' => $this->generateSeo(
                'URL Slug Generator - Create Clean, SEO-Friendly URLs',
                'Generate clean, search engine friendly URL slugs from any text. Customize separators and remove stop words easily.'
            ),
            'tools' => $this->getTools(),
            'currentTool' => 'slug-generator.index'
        ]);
    }
}
