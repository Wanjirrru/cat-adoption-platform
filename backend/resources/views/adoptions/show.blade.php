<x-app-layout>
    <div class="container mx-auto p-6 max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Adoption Details for {{ $adoption->cat->name }}</h2>

        <form action="{{ route('adoptions.update', $adoption->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Display Adoption Information -->
            <div class="mb-4">
                <p class="text-gray-700"><strong>Cat:</strong> {{ $adoption->cat->name }}</p>
                <p class="text-gray-700"><strong>Current Status:</strong> {{ ucfirst($adoption->status) }}</p>
            </div>

            <!-- Status dropdown for updating the adoption status -->
            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium mb-2">Update Status:</label>
                <select name="status" id="status" class="form-select block w-full border-gray-300 rounded-lg p-2">
                    <option value="pending" {{ $adoption->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ $adoption->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="declined" {{ $adoption->status == 'declined' ? 'selected' : '' }}>Declined</option>
                </select>
            </div>

            <!-- Submit button to update the status -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Update Status
            </button>
        </form>

        <!-- Optionally, add a back link or other information -->
        <div class="mt-4">
            <a href="{{ route('adoptions') }}" class="text-blue-600 hover:text-blue-800">Back to All Adoptions</a>
        </div>
    </div>
</x-app-layout>