<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $properties = Property::query();

        if ($request->has('city')) {
            $properties->where('city', $request->city);
        }

        if ($request->has('type')) {
            $properties->where('type', $request->type);
        }

        if ($request->has('status')) {
            $properties->where('status', $request->status);
        }

        if ($request->has('min_price')) {
            $properties->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $properties->where('price', '<=', $request->max_price);
        }

        return response()->json($properties->get());
    }

    public function show($id): JsonResponse
    {
        $property = Property::findOrFail($id);
        return response()->json($property);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'owner_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|in:sale,rent',
            'property_type' => 'required|in:house,apartment,land,commercial',
            'city' => 'required|string',
            'address' => 'required|string',
            'rooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'surface' => 'required|numeric',
            'features' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $images[] = $path;
            }
        }

        $property = Property::create([
            'owner_id' => $request->owner_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type,
            'property_type' => $request->property_type,
            'city' => $request->city,
            'address' => $request->address,
            'rooms' => $request->rooms,
            'bathrooms' => $request->bathrooms,
            'surface' => $request->surface,
            'features' => $request->features,
            'images' => $images,
            'is_available' => $request->is_available,
        ]);

        return response()->json($property, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'owner_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|in:sale,rent',
            'property_type' => 'required|in:house,apartment,land,commercial',
            'city' => 'required|string',
            'address' => 'required|string',
            'rooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'surface' => 'required|numeric',
            'features' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $images = $property->images;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $images[] = $path;
            }
        }

        $property->update([
            'owner_id' => $request->owner_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type,
            'property_type' => $request->property_type,
            'city' => $request->city,
            'address' => $request->address,
            'rooms' => $request->rooms,
            'bathrooms' => $request->bathrooms,
            'surface' => $request->surface,
            'features' => $request->features,
            'images' => $images,
            'is_available' => $request->is_available,
        ]);

        return response()->json($property);
    }

    public function viewDemo()
    { return view('site.index');}
}
