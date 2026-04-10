<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    protected function generateSeo($title, $description)
    {
        return [
            'title' => $title . ' - ToolsCraft',
            'description' => $description,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebApplication',
                'name' => $title,
                'description' => $description,
                'url' => url()->current()
            ]
        ];
    }
}
