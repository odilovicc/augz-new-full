<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Question::latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $questions = $query->paginate(20);

        return QuestionResource::collection($questions)->response();
    }

    public function show(Question $question): JsonResponse
    {
        return (new QuestionResource($question))->response();
    }

    public function update(Request $request, Question $question): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,in_progress,answered'],
        ]);
        $question->update($data);

        return (new QuestionResource($question))->response();
    }

    public function destroy(Question $question): Response
    {
        $question->delete();

        return response()->noContent();
    }
}
