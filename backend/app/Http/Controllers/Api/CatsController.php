<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatsController extends BaseController
{
    public function __construct()
    {
        // Apply middleware only to actions that need protection
        $this->middleware('permission:edit cats|delete cats', ['only' => ['update', 'destroy']]);
        $this->middleware('permission:create cats', ['only' => ['store']]);
    }

    public function index()
    {
        $cats = Cat::where('is_adopted', false)
            ->select('id', 'name', 'breed', 'gender', 'age', 'description', 'price', 'images', 'is_adopted')
            ->latest()
            ->paginate(12);

        return response()->json([
            'data' => $cats->items(),
            'meta' => [
                'current_page' => $cats->currentPage(),
                'last_page' => $cats->lastPage(),
                'total' => $cats->total(),
            ],
        ]);
    }

    public function show(Cat $cat)
    {
        $user = auth()->user();

    if ($user) {
        // Load ONLY this user's adoption requests for this cat
        $cat->load([
            'adoptions' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ]);
    } else {
        // Guests get no adoption info
        $cat->setRelation('adoptions', collect([]));
    }

    // Optional: if you want to include payment for the adoption, load it too
    // $cat->load('adoptions.payment');

    return response()->json([
        'data' => $cat,
        'message' => 'Cat details retrieved successfully'
    ]); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'breed'       => 'nullable|string',
            'gender'      => 'nullable|in:male,female,unknown',
            'age'         => 'nullable|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'is_adopted'  => 'boolean',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:2048',
        ]);

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('cats', 'public');
            }
            $validated['images'] = $paths;
        }

        $cat = Cat::create($validated);

        // Original behaviour: auto-create a pending adoption for the creator
        if (auth()->check()) {
            $cat->adoptions()->create([
                'user_id' => auth()->id(),
                'status'  => 'pending',
                'message' => 'Auto-created by admin',
            ]);
        }

        return response()->json([
            'message' => 'Cat created successfully',
            'data'    => $cat,
        ], 201);
    }

    public function update(Request $request, Cat $cat)
    {
        // Already protected by middleware

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'breed'       => 'nullable|string',
            'gender'      => 'nullable|in:male,female,unknown',
            'age'         => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric|min:0',
            'is_adopted'  => 'boolean',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:2048',
        ]);

        // Handle image update (delete old if new uploaded)
        if ($request->hasFile('images')) {
            if ($cat->images) {
                foreach ($cat->images as $img) {
                    Storage::disk('public')->delete($img);
                }
            }
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('cats', 'public');
            }
            $validated['images'] = $paths;
        }

        $cat->update($validated);

        return response()->json([
            'message' => 'Cat updated successfully',
            'data'    => $cat->fresh(),
        ]);
    }

    public function destroy(Cat $cat)
    {
        if ($cat->images) {
            foreach ($cat->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $cat->delete();

        return response()->json(['message' => 'Cat deleted']);
    }
}