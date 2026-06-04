<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NavbarLinkResource;
use App\Models\NavbarLink;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class NavbarController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $links = Cache::rememberForever('navbar_links', function () {
            return NavbarLink::orderBy('position')->get();
        });

        return NavbarLinkResource::collection($links);
    }
}
