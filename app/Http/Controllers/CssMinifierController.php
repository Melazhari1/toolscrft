<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class CssMinifierController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/CssMinifier', [
            'seo' => $this->generateSeo(
                'CSS Minifier and Formatter - Compress or Beautify CSS',
                'Minify your CSS code to reduce file size or format it for better readability with our free online tool.'
            ),
            'tools' => $this->getTools(),
            'currentTool' => 'css-minifier.index'
        ]);
    }
}
