<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsArticleResource;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * List published articles with filtering and sorting.
     *
     * Query params:
     *   category  — news|analytics|event|legislation|investigation
     *   tag       — exact tag string (JSONB @> match)
     *   sort      — newest(default)|oldest|popular
     *   per_page  — 1-50, default 20
     *   page      — page number
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $category = $request->query('category');
        $tag      = $request->query('tag');
        $search   = $request->query('search');
        $sort     = $request->query('sort', 'newest');
        $perPage  = min((int) $request->query('per_page', 20), 50);
        $page     = (int) $request->query('page', 1);

        $query = NewsArticle::published();

        if ($category && in_array($category, NewsArticle::CATEGORIES, true)) {
            $query->category($category);
        }

        if ($tag) {
            $query->whereRaw('tags @> ?::jsonb', [json_encode([$tag])]);
        }

        if ($search) {
            $like = '%' . mb_strtolower($search) . '%';
            $query->where(function ($q) use ($like) {
                $q->whereRaw('LOWER(title) LIKE ?', [$like])
                  ->orWhereRaw('LOWER(excerpt) LIKE ?', [$like]);
            });
        }

        match ($sort) {
            'oldest'  => $query->orderBy('published_at'),
            'popular' => $query->orderByDesc('views'),
            default   => $query->orderByDesc('published_at'),
        };

        // Paginate without caching the paginator object — cache the raw data array instead
        $paginated = $query->paginate($perPage, ['*'], 'page', $page);

        return NewsArticleResource::collection($paginated);
    }

    /**
     * Featured articles — cached as plain array, not paginator.
     */
    public function featured(Request $request): AnonymousResourceCollection
    {
        $ids = Cache::remember('news:featured:ids', 600, function () {
            return NewsArticle::published()
                ->featured()
                ->orderByDesc('published_at')
                ->limit(3)
                ->pluck('id')
                ->toArray();
        });

        $collection = NewsArticle::whereIn('id', $ids)
            ->orderByDesc('published_at')
            ->get();

        return NewsArticleResource::collection($collection);
    }

    /**
     * All available tags with usage counts — cached as plain array.
     */
    public function tags(): \Illuminate\Http\JsonResponse
    {
        $tags = Cache::remember('news:tags', 600, function () {
            return DB::select(
                "SELECT tag, count(*)::int as count
                 FROM news_articles, jsonb_array_elements_text(tags) AS tag
                 WHERE published_at IS NOT NULL AND published_at <= NOW()
                 GROUP BY tag
                 ORDER BY count DESC, tag"
            );
        });

        return response()->json($tags);
    }

    /**
     * Per-category counts — cached as plain array.
     */
    public function categoryCounts(): \Illuminate\Http\JsonResponse
    {
        $counts = Cache::remember('news:category_counts', 600, function () {
            return NewsArticle::published()
                ->selectRaw('category, count(*)::int as count')
                ->groupBy('category')
                ->pluck('count', 'category')
                ->toArray();
        });

        return response()->json($counts);
    }

    /**
     * Show single article and increment view counter atomically.
     */
    public function show(NewsArticle $newsArticle): NewsArticleResource
    {
        $newsArticle->incrementViews();

        return new NewsArticleResource($newsArticle);
    }
}
