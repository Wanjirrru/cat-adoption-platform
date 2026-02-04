<x-app-layout>
    <div class="container mx-auto px-5 py-12">
        <!-- Cat Name -->
        <h1 class="text-4xl font-bold text-rose-600 mb-8">{{ $cat->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Cat Images Section -->
            <div>
                @if ($cat->images && is_array($cat->images))
                    <div class="space-y-4">
                        @foreach ($cat->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" class="w-full h-auto rounded-lg shadow-lg" alt="Cat Image">
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No images available for {{ $cat->name }}</p>
                @endif
            </div>

            <!-- Cat Details Section -->
            <div class="space-y-6">
                <p class="text-lg"><strong class="font-medium text-gray-800">Breed:</strong> {{ $cat->breed }}</p>
                <p class="text-lg"><strong class="font-medium text-gray-800">Age:</strong> {{ $cat->age }} years old</p>
                <p class="text-lg"><strong class="font-medium text-gray-800">Description:</strong> {{ $cat->description }}</p>
                <p class="text-lg"><strong class="font-medium text-gray-800">Price:</strong> ${{ $cat->price }}</p>

                <!-- Adoption Button for Regular Users -->
                @if(Auth::check() && Auth::user()->hasRole('user'))
                    @if (!$cat->is_adopted)
                        <a href="{{ route('adoptions.create', $cat->id) }}" class="inline-block px-6 py-3 bg-rose-600 text-white font-medium rounded-lg shadow hover:bg-rose-700 transition-transform transform hover:scale-105">Apply for Adoption</a>
                    @else
                        <p class="text-rose-500 font-medium">This cat is adopted</p>
                    @endif
                @endif

                <!-- Edit Button for Admins/Super-Admins -->
                @if(Auth::check() && (Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('admin')))
                    <a href="{{ route('cats.edit', $cat->id) }}" class="inline-block px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow hover:bg-green-700 transition-transform transform hover:scale-105">Edit Cat</a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>