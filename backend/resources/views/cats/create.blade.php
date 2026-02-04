<x-app-layout>
    <div class="container mx-auto px-5 py-12">
        <h1 class="text-3xl font-bold text-rose-600 mb-5">Add New Cat</h1>
        <form action="{{ route('cats.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-lg rounded-lg p-6 space-y-6">
            @csrf
            <!-- Name -->
            <div>
                <label for="name" class="block text-lg font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-rose-600 focus:border-rose-600" required>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-rose-600 focus:border-rose-600"></textarea>
            </div>

            <!-- Breed -->
            <div>
                <label for="breed" class="block text-lg font-medium text-gray-700">Breed</label>
                <input type="text" name="breed" id="breed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-rose-600 focus:border-rose-600">
            </div>

            <!-- Age -->
            <div>
                <label for="age" class="block text-lg font-medium text-gray-700">Age</label>
                <input type="number" name="age" id="age" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-rose-600 focus:border-rose-600">
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-lg font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-rose-600 focus:border-rose-600" required>
            </div>

            <!-- Adopted Checkbox -->
            <div class="flex items-center">
                <input type="checkbox" name="is_adopted" id="is_adopted" value="1" class="rounded border-gray-300 text-rose-600 shadow-sm focus:ring-rose-600">
                <label for="is_adopted" class="ml-2 text-lg font-medium text-gray-700">Adopted</label>
            </div>

            <!-- Images -->
            <div>
                <label for="images" class="block text-lg font-medium text-gray-700">Images</label>
                <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-rose-600 focus:border-rose-600">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-rose-600 text-white font-medium py-3 rounded-md hover:bg-rose-700 shadow-lg transition-transform transform hover:scale-105">
                Add Cat
            </button>
        </form>
    </div>
</x-app-layout>