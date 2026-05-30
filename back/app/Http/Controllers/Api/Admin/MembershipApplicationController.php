<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMembershipApplicationRequest;
use App\Http\Resources\MembershipApplicationResource;
use App\Models\MembershipApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MembershipApplicationController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = MembershipApplication::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return MembershipApplicationResource::collection($query->get());
    }

    public function show(MembershipApplication $membershipApplication): MembershipApplicationResource
    {
        return new MembershipApplicationResource($membershipApplication);
    }

    public function update(UpdateMembershipApplicationRequest $request, MembershipApplication $membershipApplication): MembershipApplicationResource
    {
        $membershipApplication->update($request->validated());

        return new MembershipApplicationResource($membershipApplication->fresh());
    }

    public function destroy(MembershipApplication $membershipApplication): JsonResponse
    {
        $membershipApplication->delete();

        return response()->json(['message' => 'Application deleted.']);
    }
}
