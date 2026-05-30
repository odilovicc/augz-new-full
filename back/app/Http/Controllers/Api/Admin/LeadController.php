<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeadController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Lead::latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($source = $request->query('source')) {
            $query->where('source', $source);
        }

        return LeadResource::collection($query->paginate(20))->response();
    }

    public function update(Request $request, Lead $lead): JsonResponse
    {
        $lead->update($request->validate([
            'status' => ['required', 'in:new,contacted,converted'],
        ]));

        return (new LeadResource($lead))->response();
    }

    public function destroy(Lead $lead): Response
    {
        $lead->delete();
        return response()->noContent();
    }
}
