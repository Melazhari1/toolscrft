<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function howItWorks()
    {
        return Inertia::render('HowItWorks', [
            'seo' => $this->generateSeo(
                'How It Works',
                'Learn how ToolsCraft processes your data locally and securely.'
            )
        ]);
    }

    public function privacyPolicy()
    {
        return Inertia::render('PrivacyPolicy', [
            'seo' => $this->generateSeo(
                'Privacy Policy',
                'Read about our commitment to your privacy and local-first data processing.'
            )
        ]);
    }
}
