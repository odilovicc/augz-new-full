<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegulatoryDocumentResource;
use App\Models\RegulatoryDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RegulatoryDocumentController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = RegulatoryDocument::active();

        if ($type = $request->query('type')) {
            if (in_array($type, RegulatoryDocument::TYPES, true)) {
                $query->where('type', $type);
            }
        }

        $documents = $query->orderBy('sort_order')->orderBy('created_at')->get();

        return RegulatoryDocumentResource::collection($documents);
    }
}
