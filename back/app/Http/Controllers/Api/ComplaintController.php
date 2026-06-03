<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Mail\ComplaintReceived;
use App\Models\Complaint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ComplaintController extends Controller
{
    public function store(StoreComplaintRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('attachments')) {
            $files = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('complaints/attachments', 'public');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'url'  => asset("storage/{$path}"),
                    'mime' => $file->getMimeType(),
                ];
            }
            $data['attachments'] = $files;
        }

        $complaint = Complaint::create(array_merge(
            $data,
            ['track_code' => Complaint::generateTrackCode()]
        ));

        if (!empty($data['email'])) {
            Mail::to($data['email'])->send(new ComplaintReceived($complaint->fresh()));
        }

        return (new ComplaintResource($complaint->fresh()))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total'    => Complaint::count(),
            'launched' => 'май 2026',
            'avg_days' => 10,
        ]);
    }

    public function track(string $code): JsonResponse
    {
        $complaint = Complaint::where('track_code', strtoupper($code))->first();

        if (! $complaint) {
            return response()->json(['message' => 'Complaint not found.'], 404);
        }

        return (new ComplaintResource($complaint))->response();
    }
}
