<x-app-layout>
    <div class="container mx-auto max-w-2xl px-4 py-12">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Adopt {{ $cat->name }}</h1>

        <form action="{{ route('adoptions.store.cat', $cat->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')
            <!-- Message field -->
            <div>
                <label for="message" class="block text-lg font-medium text-gray-700 mb-2">
                    Why do you want to adopt {{ $cat->name }}?
                </label>
                <textarea
                    name="message"
                    id="message"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-rose-500 focus:border-rose-500"
                    rows="5"
                    required
                ></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow-md hover:bg-green-700 transition-transform transform hover:scale-105">
                Submit Adoption Request
            </button>
        </form>
    </div>
</x-app-layout>