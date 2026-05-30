<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VideoController extends Controller
{
    /**
     * List all videos ordered by sort_order asc, then created_at desc.
     */
    public function index(): AnonymousResourceCollection
    {
        $videos = Video::orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return VideoResource::collection($videos);
    }
}
