<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTradingPlatformRequest;
use App\Http\Requests\UpdateTradingPlatformRequest;
use App\Http\Resources\TradingPlatformResource;
use App\Models\TradingPlatform;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TradingPlatformController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $platforms = TradingPlatform::orderBy('sort_order')->orderBy('created_at')->get();

        return TradingPlatformResource::collection($platforms);
    }

    public function store(StoreTradingPlatformRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['sort_order'] ??= (TradingPlatform::max('sort_order') ?? 0) + 1;

        $platform = TradingPlatform::create($data);

        return (new TradingPlatformResource($platform))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateTradingPlatformRequest $request, TradingPlatform $tradingPlatform): TradingPlatformResource
    {
        $tradingPlatform->update($request->validated());

        return new TradingPlatformResource($tradingPlatform->fresh());
    }

    public function destroy(TradingPlatform $tradingPlatform): JsonResponse
    {
        $tradingPlatform->delete();

        return response()->json(['message' => 'Platform deleted.']);
    }
}
