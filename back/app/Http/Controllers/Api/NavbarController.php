<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NavbarLinkResource;
use App\Models\NavbarLink;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NavbarController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $links = NavbarLink::orderBy('position')->get();

        return NavbarLinkResource::collection($links);
    }
}
