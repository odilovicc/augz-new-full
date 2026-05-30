<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function show(): JsonResponse
    {
        $page = Page::where('slug', 'settings')->first();

        return response()->json($page?->content ?? []);
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'content' => ['required', 'array'],
        ]);

        $page = Page::firstOrCreate(['slug' => 'settings'], ['content' => []]);
        $page->update(['content' => $data['content']]);

        Cache::forget('settings');

        return response()->json($page->content);
    }
}
