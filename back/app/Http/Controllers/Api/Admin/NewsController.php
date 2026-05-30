<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\NewsArticleResource;
use App\Models\NewsArticle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $category = $request->query('category');
        $sort     = $request->query('sort', 'newest');
        $perPage  = min((int) $request->query('per_page', 20), 100);

        $query = NewsArticle::query();

        if ($category && in_array($category, NewsArticle::CATEGORIES, true)) {
            $query->category($category);
        }

        match ($sort) {
            'oldest'  => $query->orderBy('published_at'),
            'popular' => $query->orderByDesc('views'),
            default   => $query->orderByDesc('published_at'),
        };

        return NewsArticleResource::collection($query->paginate($perPage));
    }

    public function store(StoreNewsRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['published_at'] ??= now();

        $article = NewsArticle::create($data);

        $this->flushNewsCache();

        return (new NewsArticleResource($article))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateNewsRequest $request, NewsArticle $newsArticle): NewsArticleResource
    {
        $newsArticle->update($request->validated());

        $this->flushNewsCache();

        return new NewsArticleResource($newsArticle->fresh());
    }

    public function destroy(NewsArticle $newsArticle): JsonResponse
    {
        $newsArticle->delete();

        $this->flushNewsCache();

        return response()->json(['message' => 'Article deleted.']);
    }

    // Flush all news-related cache keys (pattern-based via cache tags if Redis is used,
    // or flush the known static keys otherwise)
    private function flushNewsCache(): void
    {
        Cache::forget('news:tags');
        Cache::forget('news:category_counts');
        Cache::forget('news:featured:ids');
        // List cache is keyed by md5 of params — can't enumerate, so flush the whole store
        // if driver supports tags; otherwise accept stale list cache for up to 5 min.
        if (config('cache.default') === 'redis') {
            Cache::tags(['news_list'])->flush();
        }
    }
}
