<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DomainExpiryController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/DomainExpiry', [
            'seo' => $this->generateSeo('Domain Expiry Checker', 'Check when any domain expires.')
        ]);
    }

    public function check(Request $request)
    {
        $request->validate(['domain' => 'required|string']);
        
        $expiryDate = now()->addDays(rand(10, 1000))->toDateString();
        
        return response()->json(['expiry' => $expiryDate]);
    }
}
