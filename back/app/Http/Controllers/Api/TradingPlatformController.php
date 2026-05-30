<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TradingPlatformResource;
use App\Models\TradingPlatform;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TradingPlatformController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $platforms = TradingPlatform::orderBy('sort_order')->orderBy('created_at')->get();

        return TradingPlatformResource::collection($platforms);
    }
}
