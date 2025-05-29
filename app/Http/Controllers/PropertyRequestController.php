<?php

namespace App\Http\Controllers;

use App\Models\PropertyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $propertyRequests = PropertyRequest::where('user_id', $request->user()->id)->get();
        return response()->json($propertyRequests);
    }

    public function show($id): JsonResponse
    {
        $propertyRequest = PropertyRequest::findOrFail($id);
        return response()->json($propertyRequest);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|in:rent,purchase',
            'message' => 'nullable|string',
        ]);

        $propertyRequest = PropertyRequest::create([
            'user_id' => $request->user()->id,
            'property_id' => $request->property_id,
            'type' => $request->type,
            'message' => $request->message,
        ]);

        return response()->json($propertyRequest, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $propertyRequest = PropertyRequest::findOrFail($id);

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|in:rent,purchase',
            'message' => 'nullable|string',
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $propertyRequest->update([
            'property_id' => $request->property_id,
            'type' => $request->type,
            'message' => $request->message,
            'status' => $request->status,
        ]);

        return response()->json($propertyRequest);
    }

    public function destroy($id): JsonResponse
    {
        $propertyRequest = PropertyRequest::findOrFail($id);
        $propertyRequest->delete();
        return response()->json(null, 204);
    }
}
