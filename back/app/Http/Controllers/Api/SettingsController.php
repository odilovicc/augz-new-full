<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function show(): JsonResponse
    {
        $data = Cache::remember('settings', 3600, function () {
            return Page::where('slug', 'settings')->value('content') ?? [];
        });

        return response()->json($data);
    }
}
