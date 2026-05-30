<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TestimonialController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TestimonialResource::collection(
            Testimonial::orderBy('sort_order')->orderBy('created_at')->get()
        );
    }

    public function store(StoreTestimonialRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['sort_order'] ??= (Testimonial::max('sort_order') ?? 0) + 1;

        $testimonial = Testimonial::create($data);

        return (new TestimonialResource($testimonial))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial): TestimonialResource
    {
        $testimonial->update($request->validated());

        return new TestimonialResource($testimonial->fresh());
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $testimonial->delete();

        return response()->json(['message' => 'Testimonial deleted.']);
    }
}
