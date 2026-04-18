<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class CsvToJsonController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/CsvToJson', [
            'seo' => $this->generateSeo('Convert CSV files and data directly to JSON', 'Transform CSV data into JSON arrays or objects with custom parsing options, header detection, and type conversion for API integration.'),
            'tools' => $this->getTools(),
            'currentTool' => 'csv-to-json.index'
        ]);
    }
}
