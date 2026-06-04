<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\NavbarLinkResource;
use App\Models\NavbarLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Cache;

class NavbarController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $links = NavbarLink::orderBy('position')->get();
        return NavbarLinkResource::collection($links);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'label'    => ['required', 'array'],
            'label.ru' => ['required', 'string', 'max:200'],
            'label.uz' => ['nullable', 'string', 'max:200'],
            'label.en' => ['nullable', 'string', 'max:200'],
            'href'     => ['required', 'string', 'max:500'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['position'] ??= (NavbarLink::max('position') ?? 0) + 1;

        $link = NavbarLink::create($data);

        Cache::forget('navbar_links');

        return (new NavbarLinkResource($link))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, NavbarLink $navbarLink): NavbarLinkResource
    {
        $data = $request->validate([
            'label'    => ['sometimes', 'array'],
            'label.ru' => ['required_with:label', 'string', 'max:200'],
            'label.uz' => ['nullable', 'string', 'max:200'],
            'label.en' => ['nullable', 'string', 'max:200'],
            'href'     => ['sometimes', 'string', 'max:500'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $navbarLink->update($data);

        Cache::forget('navbar_links');

        return new NavbarLinkResource($navbarLink->fresh());
    }

    public function destroy(NavbarLink $navbarLink): JsonResponse
    {
        $navbarLink->delete();

        Cache::forget('navbar_links');

        return response()->json(['message' => 'Link deleted.']);
    }
}
