<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriptionTypeRequest;
use App\Http\Requests\EditSubscriptionTypeRequest;
use App\Models\SubscriptionType;
use Illuminate\Http\JsonResponse;

class SubscriptionTypeController extends Controller
{
    public function get(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'data' => SubscriptionType::all(),
        ]);
    }

    public function create(CreateSubscriptionTypeRequest $request): JsonResponse
    {
        $data = $request->validated();

        SubscriptionType::create($data);

        return response()->json([
            'status' => 'ok',
        ], 201);
    }

    public function delete(SubscriptionType $subscriptionType): JsonResponse
    {
        $subscriptionType->delete();

        return response()->json([
            'status' => 'ok',
        ], 200);
    }

    public function edit(EditSubscriptionTypeRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        /** @var SubscriptionType|null */
        $st = SubscriptionType::find($id);

        if ($st !== null) {
            $st->update($data);
        }

        return response()->json([
            'status' => 'ok',
        ], 200);
    }
}
