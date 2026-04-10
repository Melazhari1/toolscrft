<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DomainWhoisController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools/DomainWhois', [
            'seo' => $this->generateSeo('Whois Lookup', 'Lookup whois data for any domain.')
        ]);
    }

    public function check(Request $request)
    {
        $request->validate(['domain' => 'required|string']);
        
        return response()->json([
            'domain' => $request->domain,
            'registrar' => 'Example Registrar, Inc.',
            'creation_date' => '2000-01-01',
            'status' => 'active'
        ]);
    }
}
