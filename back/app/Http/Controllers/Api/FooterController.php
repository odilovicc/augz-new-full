<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FooterColumnResource;
use App\Models\FooterColumn;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class FooterController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $columns = FooterColumn::with('links')->orderBy('position')->get();

        return FooterColumnResource::collection($columns);
    }
}
