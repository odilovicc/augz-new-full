<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FooterColumnResource;
use App\Http\Resources\FooterLinkResource;
use App\Models\FooterColumn;
use App\Models\FooterLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class FooterController extends Controller
{
    // ── Columns ──────────────────────────────────────────────────────────────

    public function indexColumns(): AnonymousResourceCollection
    {
        $columns = FooterColumn::with('links')->orderBy('position')->get();

        return FooterColumnResource::collection($columns);
    }

    public function storeColumn(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'          => ['required', 'array'],
            'title.ru'       => ['required', 'string', 'max:100'],
            'title.uz'       => ['nullable', 'string', 'max:100'],
            'title.en'       => ['nullable', 'string', 'max:100'],
            'position'       => ['nullable', 'integer', 'min:0'],
        ]);

        $data['position'] ??= (FooterColumn::max('position') ?? 0) + 1;

        $column = FooterColumn::create($data);

        Cache::forget('footer_columns');

        return (new FooterColumnResource($column->load('links')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function updateColumn(Request $request, FooterColumn $footerColumn): FooterColumnResource
    {
        $data = $request->validate([
            'title'          => ['sometimes', 'array'],
            'title.ru'       => ['required_with:title', 'string', 'max:100'],
            'title.uz'       => ['nullable', 'string', 'max:100'],
            'title.en'       => ['nullable', 'string', 'max:100'],
            'position'       => ['nullable', 'integer', 'min:0'],
        ]);

        $footerColumn->update($data);

        Cache::forget('footer_columns');

        return new FooterColumnResource($footerColumn->fresh()->load('links'));
    }

    public function destroyColumn(FooterColumn $footerColumn): JsonResponse
    {
        $footerColumn->delete();

        Cache::forget('footer_columns');

        return response()->json(['message' => 'Column deleted.']);
    }

    // ── Links ─────────────────────────────────────────────────────────────────

    public function storeLink(Request $request, FooterColumn $footerColumn): JsonResponse
    {
        $data = $request->validate([
            'label'    => ['required', 'array'],
            'label.ru' => ['required', 'string', 'max:200'],
            'label.uz' => ['nullable', 'string', 'max:200'],
            'label.en' => ['nullable', 'string', 'max:200'],
            'href'     => ['required', 'string', 'max:500'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['footer_column_id'] = $footerColumn->id;
        $data['position'] ??= ($footerColumn->links()->max('position') ?? 0) + 1;

        $link = FooterLink::create($data);

        Cache::forget('footer_columns');

        return (new FooterLinkResource($link))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function updateLink(Request $request, FooterColumn $footerColumn, FooterLink $link): FooterLinkResource
    {
        abort_if($link->footer_column_id !== $footerColumn->id, 404);

        $data = $request->validate([
            'label'    => ['sometimes', 'array'],
            'label.ru' => ['required_with:label', 'string', 'max:200'],
            'label.uz' => ['nullable', 'string', 'max:200'],
            'label.en' => ['nullable', 'string', 'max:200'],
            'href'     => ['sometimes', 'string', 'max:500'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $link->update($data);

        Cache::forget('footer_columns');

        return new FooterLinkResource($link->fresh());
    }

    public function destroyLink(FooterColumn $footerColumn, FooterLink $link): JsonResponse
    {
        abort_if($link->footer_column_id !== $footerColumn->id, 404);

        $link->delete();

        Cache::forget('footer_columns');

        return response()->json(['message' => 'Link deleted.']);
    }
}
