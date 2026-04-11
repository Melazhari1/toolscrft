<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class JsonToCsvController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/JsonToCsv', [
            'seo' => $this->generateSeo('Convert JSON objects and arrays directly to CSV', 'Transform JSON objects and arrays into CSV files with custom delimiters, headers, quoting, and nested field flattening for spreadsheet export.')
        ]);
    }
}
