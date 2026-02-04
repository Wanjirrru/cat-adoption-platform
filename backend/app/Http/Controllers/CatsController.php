<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CatsController extends Controller
{

    public function index()
    {
        $cats = Cat::where('is_adopted', false)->paginate(10);
        return view('cats.index', compact('cats'));
    }

    public function create()
    {
        return view('cats.create');
    }

    public function edit(Cat $cat)
    {
        return view('cats.edit', compact('cat'));
    }

    public function show(Cat $cat)
    {
        return view('cats.show', ['cat' => $cat]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'breed' => 'nullable|string',
            'age' => 'nullable|integer',
            'is_adopted' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        // Handle the image upload if present
        if ($request->has('images')) {
        $imagePaths = [];
        foreach ($request->file('images') as $image) {
            $path = $image->store('cats', 'public');
            $imagePaths[] = $path;
        }
        $validated['images'] = $imagePaths;
        }

        $cat = Cat::create($validated);

        $userId = auth()->id();
        if ($userId) {
            Adoption::create([
                'cat_id' => $cat->id,
                'user_id' => $userId,
                'status' => Adoption::STATUS_PENDING,
            ]);
        }
       $cats = Cat::where('is_adopted', false)->paginate(10);
    return view('cats.index', [
        'cats' => $cats,
        'status' => 'Cat created and added to adoption list successfully!',
    ]);
    }

    public function update(Request $request, Cat $cat)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'breed' => 'nullable|string',
            'age' => 'nullable|integer',
            'is_adopted' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

            if ($request->has('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('cats', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
            }
        $cat->update($validated);

        return redirect()->route('cats.index')->with('success', 'Cat updated successfully!');
    }

    public function destroy(Cat $cat)
    {
        $cat->delete();
        return redirect()->route('cats.index')->with('success', 'Cat deleted successfully!');
    }

    private function uploadImages(array $images)
    {
        $paths = [];
        foreach ($images as $image) {
        $paths[] = $image->store('cats', 'public');
        }
        return $paths;
   }


    private function deleteImages(array $images)
    {
       foreach ($images as $image) {
        Storage::disk('public')->delete($image);
       }
    }

}