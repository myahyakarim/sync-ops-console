<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SyncJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SyncJobController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = SyncJob::query()->latest();

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        return response()->json([
            'data' => $query->limit(100)->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'reference' => ['required', 'string', 'max:64'],
            'job_type' => ['required', 'string', 'max:64'],
            'payload' => ['nullable', 'array'],
        ]);

        $job = SyncJob::query()->create([
            ...$data,
            'status' => SyncJob::STATUS_QUEUED,
            'attempts' => 0,
        ]);

        return response()->json(['data' => $job], 201);
    }

    public function requeue(SyncJob $syncJob): JsonResponse
    {
        $syncJob->update([
            'status' => SyncJob::STATUS_QUEUED,
            'attempts' => $syncJob->attempts + 1,
            'last_error' => null,
        ]);

        return response()->json(['data' => $syncJob->fresh()]);
    }
}
