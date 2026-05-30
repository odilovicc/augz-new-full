<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function image(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'mimes:jpeg,jpg,png,gif,webp,svg', 'max:5120'],
        ]);

        $path = $request->file('image')->store('news', 'public');

        return response()->json([
            'url' => asset("storage/{$path}"),
        ]);
    }
}
