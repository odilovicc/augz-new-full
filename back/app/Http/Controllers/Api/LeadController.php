<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): JsonResponse
    {
        $lead = Lead::create([
            ...$request->validated(),
            'source' => $request->input('source', 'unknown'),
            'type'   => $request->input('type', 'free'),
        ]);

        return (new LeadResource($lead))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
