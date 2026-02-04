<x-app-layout>
    <div class="container mx-auto px-5 py-12">
        <h1 class="text-3xl font-bold text-rose-600 mb-8">Edit Cat</h1>

        <form action="{{ route('cats.update', $cat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <!-- Cat Name -->
            <div class="form-group">
                <label for="name" class="block text-gray-800 font-medium mb-2">Name</label>
                <input type="text" name="name" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $cat->name }}" required>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="block text-gray-800 font-medium mb-2">Description</label>
                <textarea name="description" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-lg" rows="3">{{ $cat->description }}</textarea>
            </div>

            <!-- Breed -->
            <div class="form-group">
                <label for="breed" class="block text-gray-800 font-medium mb-2">Breed</label>
                <input type="text" name="breed" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $cat->breed }}">
            </div>

            <!-- Age -->
            <div class="form-group">
                <label for="age" class="block text-gray-800 font-medium mb-2">Age</label>
                <input type="number" name="age" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $cat->age }}">
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="price" class="block text-gray-800 font-medium mb-2">Price</label>
                <input type="number" name="price" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-lg" step="0.01" value="{{ $cat->price }}" required>
            </div>

            <!-- Adoption Status -->
            <div class="form-group">
                <label for="is_adopted" class="block text-gray-800 font-medium mb-2">Adopted</label>
                <input type="checkbox" name="is_adopted" value="1" {{ $cat->is_adopted ? 'checked' : '' }} class="rounded text-rose-600 focus:ring-rose-500">
            </div>

            <!-- New Images Upload -->
            <div class="form-group">
                <label for="images" class="block text-gray-800 font-medium mb-2">Add New Images</label>
                <input type="file" name="images[]" multiple class="block w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>

            <!-- Existing Images -->
            <div class="form-group">
                <label class="block text-gray-800 font-medium mb-2">Existing Images:</label>
                <div class="flex flex-wrap gap-4">
                    @if ($cat->images && is_array($cat->images))
                        @foreach ($cat->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $cat->name }}" class="rounded-lg shadow-md" style="max-height: 100px;">
                        @endforeach
                    @else
                        <p class="text-gray-600">No images available for {{ $cat->name }}</p>
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="px-6 py-3 bg-rose-600 text-white font-medium rounded-lg shadow hover:bg-rose-700 transition-transform transform hover:scale-105">
                Update Cat
            </button>
        </form>
    </div>
</x-app-layout>