<x-app-layout>
    <div class="container mx-auto px-5 py-12">
        <h1 class="text-3xl font-bold text-rose-600 mb-8">Available Cuties</h1>

        <!-- Add New Cat Button for Super Admin/Admin -->
        @if(Auth::check() && Auth::user()->hasRole('super-admin|admin'))
            <a href="{{ route('cats.create') }}" class="mb-6 inline-block px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow hover:bg-green-700 transition-transform transform hover:scale-105">
                Add New Cat
            </a>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($cats as $cat)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @php
                        $images = is_string($cat->images) ? json_decode($cat->images, true) : $cat->images;
                    @endphp

                    <!-- Cat Image -->
                    <img
                        src="{{ isset($images[0]) ? asset('storage/' . $images[0]) : asset('storage/default-image.jpg') }}"
                        alt="{{ $cat->name }}"
                        class="w-full h-48 object-cover"
                    >

                    <!-- Cat Details -->
                    <div class="p-4">
                        <h5 class="text-xl font-bold text-gray-800">{{ $cat->name }}</h5>
                        <p class="text-gray-600">Breed: {{ $cat->breed }}</p>
                        <p class="text-gray-600">Price: ${{ $cat->price }}</p>
                        <p class="text-gray-700 mt-2">{{ $cat->description }}</p>

                        <div class="mt-4 space-y-2">
                            <!-- View Details Button -->
                            <a href="{{ route('cats.show', $cat->id) }}" class="block px-4 py-2 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-transform transform hover:scale-105">
                                View Details
                            </a>

                            <!-- Delete Button for Super Admin/Admin -->
                            @if(Auth::check() && Auth::user()->hasRole('super-admin|admin'))
                                <form action="{{ route('cats.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this cat?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-transform transform hover:scale-105">
                                        Delete Cat
                                    </button>
                                </form>
                            @endif

                            <!-- Adopt Button for Users -->
                            @if(Auth::check() && Auth::user()->hasRole('user'))
                                <a href="{{ route('adoptions.create', $cat->id) }}" class="block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-transform transform hover:scale-105">
                                    Adopt
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $cats->links() }}
        </div>
    </div>
</x-app-layout>