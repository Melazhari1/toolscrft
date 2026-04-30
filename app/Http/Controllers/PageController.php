<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function howItWorks()
    {
        return Inertia::render('HowItWorks', [
            'seo' => $this->generateSeo(
                'How ToolsCraft processes your data locally',
                'Learn how ToolsCraft runs tools in the browser, keeps your data local, and avoids third-party tracking for fast secure utility workflows.'
            )
        ]);
    }

    public function privacyPolicy()
    {
        return Inertia::render('PrivacyPolicy', [
            'seo' => $this->generateSeo(
                'ToolsCraft privacy policy for secure local data usage',
                'Read ToolsCraft’s privacy commitment for local-first data handling, no tracking, and browser-based security. Understand how your input stays private as you use the tools.'
            )
        ]);
    }

    public function sitemap()
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('how-it-works'), 'priority' => '0.8'],
            ['loc' => route('privacy-policy'), 'priority' => '0.8'],
            ['loc' => url('/llm.txt'), 'priority' => '0.9'],
        ];

        foreach ($this->getTools() as $tool) {
            $urls[] = ['loc' => route($tool['slug']), 'priority' => '0.9'];
        }

        $lastMod = now()->toAtomString();
        $xml = view('sitemap', compact('urls', 'lastMod'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
