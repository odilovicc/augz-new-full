<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
