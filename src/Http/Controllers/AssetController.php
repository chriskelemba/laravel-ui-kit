<?php

namespace ChrisKelemba\LaravelUiKit\Http\Controllers;

class AssetController
{
    public function css()
    {
        return response()->file(__DIR__ . '/../../../resources/dist/ui-kit.css', [
            'Content-Type' => 'text/css; charset=UTF-8',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
