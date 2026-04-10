<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class JsonToCsvController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/JsonToCsv', [
            'seo' => $this->generateSeo('JSON to CSV', 'Convert JSON format directly to CSV.')
        ]);
    }
}
