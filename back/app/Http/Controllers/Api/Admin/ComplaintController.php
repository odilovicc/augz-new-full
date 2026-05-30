<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComplaintController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Complaint::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->paginate(20);

        return ComplaintResource::collection($complaints)->response();
    }

    public function show(Complaint $complaint): ComplaintResource
    {
        return new ComplaintResource($complaint);
    }

    public function update(Request $request, Complaint $complaint): ComplaintResource
    {
        $isOfficialResponse = $request->input('status') === 'official_response'
            || ($complaint->status === 'official_response' && ! $request->has('status'));

        $request->validate([
            'status'           => ['sometimes', 'required', 'in:' . implode(',', Complaint::$statuses)],
            'admin_note'       => ['sometimes', 'nullable', 'string'],
            'response_message' => [
                $isOfficialResponse ? 'required' : 'sometimes',
                'nullable',
                'string',
                'min:10',
            ],
            'kept_files'       => ['sometimes', 'nullable', 'string'],
            'response_files'   => ['sometimes', 'array', 'max:10'],
            'response_files.*' => ['file', 'mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx', 'max:10240'],
        ]);

        $data = $request->only(['status', 'admin_note', 'response_message']);

        // Reconcile kept vs removed files, then append new uploads
        $keptUrls = $request->filled('kept_files')
            ? json_decode($request->input('kept_files'), true)
            : null;

        $existingFiles = $complaint->response_files ?? [];

        if ($keptUrls !== null) {
            $existingFiles = array_values(
                array_filter($existingFiles, fn ($f) => in_array($f['url'], $keptUrls))
            );
        }

        if ($request->hasFile('response_files')) {
            foreach ($request->file('response_files') as $file) {
                $path = $file->store('complaints/responses', 'public');
                $existingFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'url'  => asset("storage/{$path}"),
                    'mime' => $file->getMimeType(),
                ];
            }
        }

        $data['response_files'] = $existingFiles;

        $complaint->update($data);

        return new ComplaintResource($complaint->fresh());
    }

    public function deleteResponseFile(Request $request, Complaint $complaint): ComplaintResource
    {
        $request->validate(['url' => ['required', 'string']]);

        $files = collect($complaint->response_files ?? [])
            ->reject(fn ($f) => $f['url'] === $request->url)
            ->values()
            ->all();

        $complaint->update(['response_files' => $files]);

        return new ComplaintResource($complaint->fresh());
    }

    public function destroy(Complaint $complaint): Response
    {
        $complaint->delete();

        return response()->noContent();
    }
}
