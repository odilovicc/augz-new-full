<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    public function store(StoreQuestionRequest $request): JsonResponse
    {
        $question = Question::create($request->validated());

        return (new QuestionResource($question))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
