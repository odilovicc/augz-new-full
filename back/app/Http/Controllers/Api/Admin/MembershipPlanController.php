<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMembershipPlanRequest;
use App\Http\Resources\MembershipPlanResource;
use App\Models\MembershipPlan;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MembershipPlanController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return MembershipPlanResource::collection(
            MembershipPlan::orderBy('sort_order')->get()
        );
    }

    public function show(MembershipPlan $membershipPlan): MembershipPlanResource
    {
        return new MembershipPlanResource($membershipPlan);
    }

    public function update(UpdateMembershipPlanRequest $request, MembershipPlan $membershipPlan): MembershipPlanResource
    {
        $membershipPlan->update($request->validated());

        return new MembershipPlanResource($membershipPlan->fresh());
    }
}
