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
        
        $domain = $request->input('domain');
        $expiryDate = $this->getWhoisExpiry($domain);
        
        if (!$expiryDate) {
            return response()->json(['error' => 'Unable to retrieve expiry date for domain'], 400);
        }
        
        return response()->json(['expiry' => $expiryDate]);
    }

    private function getWhoisExpiry($domain)
    {
        $domain = strtolower($domain);
        $whoisServer = 'whois.verisign-grs.com';
        $port = 43;
        
        try {
            $socket = fsockopen($whoisServer, $port, $errno, $errstr, 10);
            if (!$socket) {
                return null;
            }
            
            fwrite($socket, $domain . "\r\n");
            $whoisData = '';
            while (!feof($socket)) {
                $whoisData .= fgets($socket, 128);
            }
            fclose($socket);
            
            // Parse expiry date from WHOIS response
            if (preg_match('/Registry Expiry Date:\s*(.+?)\n/i', $whoisData, $matches)) {
                $expiryDate = trim($matches[1]);
                // Convert to standard date format (YYYY-MM-DD)
                if (strtotime($expiryDate)) {
                    return date('Y-m-d', strtotime($expiryDate));
                }
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
