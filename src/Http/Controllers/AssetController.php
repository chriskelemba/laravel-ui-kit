<?php

namespace ChrisKelemba\LaravelUiKit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController
{
    public function css()
    {
        return response()->file(__DIR__ . '/../../../resources/dist/ui-kit.css', [
            'Content-Type' => 'text/css; charset=UTF-8',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    public function media(Request $request)
    {
        $disk = (string) $request->query('disk', config('ui-kit.media.default_disk', 'local'));
        $path = ltrim((string) $request->query('path', ''), '/');
        $allowedDisks = config('ui-kit.media.allowed_disks', []);

        abort_if($path === '', 404);
        abort_if($allowedDisks !== [] && ! in_array($disk, $allowedDisks, true), 403);
        abort_unless(Storage::disk($disk)->exists($path), 404);

        $stream = Storage::disk($disk)->readStream($path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);

            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => Storage::disk($disk)->mimeType($path) ?: 'application/octet-stream',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
