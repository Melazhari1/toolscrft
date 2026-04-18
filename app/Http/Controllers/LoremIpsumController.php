<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class LoremIpsumController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/LoremIpsum', [
            'seo' => $this->generateSeo('Lorem Ipsum generator for design mockups', 'Create flexible placeholder text for UI mockups, landing pages, and prototypes. Customize paragraph count, sentence length, and classic ipsum style.'),
            'tools' => $this->getTools(),
            'currentTool' => 'lorem-ipsum.index'
        ]);
    }
}
