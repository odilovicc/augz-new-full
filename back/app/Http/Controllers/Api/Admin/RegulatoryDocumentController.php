<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegulatoryDocumentRequest;
use App\Http\Requests\UpdateRegulatoryDocumentRequest;
use App\Http\Resources\RegulatoryDocumentResource;
use App\Models\RegulatoryDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class RegulatoryDocumentController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $documents = RegulatoryDocument::orderBy('sort_order')->orderBy('created_at')->get();

        return RegulatoryDocumentResource::collection($documents);
    }

    public function store(StoreRegulatoryDocumentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['sort_order'] ??= (RegulatoryDocument::max('sort_order') ?? 0) + 1;

        $document = RegulatoryDocument::create($data);

        return (new RegulatoryDocumentResource($document))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateRegulatoryDocumentRequest $request, RegulatoryDocument $regulatoryDocument): RegulatoryDocumentResource
    {
        $regulatoryDocument->update($request->validated());

        return new RegulatoryDocumentResource($regulatoryDocument->fresh());
    }

    public function destroy(RegulatoryDocument $regulatoryDocument): JsonResponse
    {
        $regulatoryDocument->delete();

        return response()->json(['message' => 'Document deleted.']);
    }
}
