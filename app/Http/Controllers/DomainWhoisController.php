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
        
        $domain = $request->input('domain');
        $whoisData = $this->getWhoisData($domain);
        
        if (!$whoisData) {
            return response()->json(['error' => 'Unable to retrieve WHOIS data for domain'], 400);
        }
        
        return response()->json($whoisData);
    }

    private function getWhoisData($domain)
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
            
            // Parse WHOIS response
            $registrar = $this->parseWhoisField($whoisData, 'Registrar');
            $creationDate = $this->parseWhoisField($whoisData, 'Creation Date');
            $status = $this->parseWhoisField($whoisData, 'Status');
            
            return [
                'domain' => $domain,
                'registrar' => $registrar ?? 'Unknown',
                'creation_date' => $creationDate ? date('Y-m-d', strtotime($creationDate)) : 'Unknown',
                'status' => $status ?? 'Unknown'
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseWhoisField($whoisData, $fieldName)
    {
        if (preg_match('/' . preg_quote($fieldName, '/') . ':\s*(.+?)\n/i', $whoisData, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }
}
