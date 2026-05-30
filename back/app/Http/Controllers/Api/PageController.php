<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    private const KNOWN_SLUGS = ['home', 'about', 'news', 'services', 'membership', 'markets', 'contacts', 'report', 'tenderzone'];

    public function show(string $slug): JsonResponse
    {
        if (! in_array($slug, self::KNOWN_SLUGS, true)) {
            return response()->json(['message' => 'Page not found.'], 404);
        }

        $data = Cache::remember("page:{$slug}", 3600, function () use ($slug) {
            return Page::where('slug', $slug)->value('content') ?? [];
        });

        return response()->json(['slug' => $slug, 'content' => $data]);
    }
}
