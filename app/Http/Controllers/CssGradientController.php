<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class CssGradientController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/CssGradient', [
            'seo' => $this->generateSeo(
                'CSS Gradient Generator - Visual Tool',
                'Create beautiful linear and radial CSS gradients with our interactive visual generator tool.'
            ),
            'tools' => $this->getTools(),
            'currentTool' => 'css-gradient.index'
        ]);
    }
}
