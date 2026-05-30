<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeaderRequest;
use App\Http\Requests\UpdateLeaderRequest;
use App\Http\Resources\LeaderResource;
use App\Models\Leader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class LeaderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return LeaderResource::collection(
            Leader::orderBy('sort_order')->orderBy('created_at')->get()
        );
    }

    public function store(StoreLeaderRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['slug']       = $this->uniqueSlug($data['name']);
        $data['sort_order'] ??= (Leader::max('sort_order') ?? 0) + 1;

        $leader = Leader::create($data);

        return (new LeaderResource($leader))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateLeaderRequest $request, Leader $leader): LeaderResource
    {
        $data = $request->validated();

        // Re-slug only if name changed
        if ($data['name'] !== $leader->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $leader->id);
        }

        $leader->update($data);

        return new LeaderResource($leader->fresh());
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (
            Leader::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function destroy(Leader $leader): JsonResponse
    {
        $leader->delete();

        return response()->json(['message' => 'Leader deleted.']);
    }
}
