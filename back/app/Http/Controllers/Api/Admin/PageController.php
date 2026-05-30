<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    private const KNOWN_SLUGS = ['home', 'about', 'news', 'services', 'membership', 'markets', 'contacts', 'report'];

    public function show(string $slug): JsonResponse
    {
        if (! in_array($slug, self::KNOWN_SLUGS, true)) {
            return response()->json(['message' => 'Page not found.'], 404);
        }

        $page = Page::where('slug', $slug)->firstOrFail();

        return response()->json(['slug' => $slug, 'content' => $page->content]);
    }

    public function update(UpdatePageRequest $request, string $slug): JsonResponse
    {
        if (! in_array($slug, self::KNOWN_SLUGS, true)) {
            return response()->json(['message' => 'Page not found.'], 404);
        }

        $page = Page::firstOrCreate(['slug' => $slug], ['content' => []]);
        $page->update(['content' => $request->validated()['content']]);

        Cache::forget("page:{$slug}");

        return response()->json(['slug' => $slug, 'content' => $page->content]);
    }
}
