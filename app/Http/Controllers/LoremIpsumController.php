<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class LoremIpsumController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/LoremIpsum', [
            'seo' => $this->generateSeo('Lorem Ipsum', 'Generate dummy text for layouts.')
        ]);
    }
}
