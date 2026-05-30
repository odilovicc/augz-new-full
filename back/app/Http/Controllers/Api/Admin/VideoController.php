<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $videos = Video::orderBy('sort_order')->orderByDesc('created_at')->get();

        return VideoResource::collection($videos);
    }

    public function store(StoreVideoRequest $request): JsonResponse
    {
        $rawUrl = $request->input('url');

        $videoId = $this->extractYoutubeId($rawUrl);

        if (! $videoId) {
            return response()->json(['message' => 'Не удалось распознать YouTube ссылку.'], 422);
        }

        $embedUrl   = "https://www.youtube.com/embed/{$videoId}?autoplay=1&rel=0";
        $thumbnail  = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        $title      = $this->fetchYoutubeTitle($rawUrl) ?? 'Видео АУГЗ';
        $sortOrder  = (Video::max('sort_order') ?? 0) + 1;

        $video = Video::create([
            'title'      => $title,
            'url'        => $embedUrl,
            'thumbnail'  => $thumbnail,
            'sort_order' => $sortOrder,
        ]);

        return (new VideoResource($video))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateVideoRequest $request, Video $video): VideoResource
    {
        $video->update($request->validated());

        return new VideoResource($video->fresh());
    }

    public function destroy(Video $video): JsonResponse
    {
        $video->delete();

        return response()->json(['message' => 'Video deleted.']);
    }

    private function extractYoutubeId(string $url): ?string
    {
        // youtu.be/ID
        if (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }
        // youtube.com/watch?v=ID  или  youtube.com/embed/ID  или  youtube.com/shorts/ID
        if (preg_match('#(?:v=|/embed/|/shorts/)([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        return null;
    }

    private function fetchYoutubeTitle(string $url): ?string
    {
        try {
            $response = Http::timeout(5)->get('https://www.youtube.com/oembed', [
                'url'    => $url,
                'format' => 'json',
            ]);

            return $response->ok() ? ($response->json('title') ?? null) : null;
        } catch (\Throwable) {
            return null;
        }
    }
}
