<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembershipApplicationRequest;
use App\Http\Resources\MembershipApplicationResource;
use App\Models\MembershipApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MembershipApplicationController extends Controller
{
    public function store(StoreMembershipApplicationRequest $request): JsonResponse
    {
        $application = MembershipApplication::create($request->validated());

        return (new MembershipApplicationResource($application))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
