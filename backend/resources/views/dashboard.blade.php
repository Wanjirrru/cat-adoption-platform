<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-5">
            <!-- Welcome Section -->
            <div class="text-center mb-32 mt-20">
                <h1 class="text-4xl font-extrabold text-rose-600"> Kiwi Adoption Agency</h1>
                <p class="text-lg text-gray-600 mt-2">Find your perfect feline companion today!</p>
            </div>

            @php
                $totalCats = \App\Models\Cat::count();
                $adoptedCats = \App\Models\Adoption::where('status', 'completed')->count(); // Cats that have been adopted
                $happyAdopters = \App\Models\User::has('adoptions')->count(); // Users who have adopted cats
            @endphp

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Total Cats</h3>
                    <p class="text-5xl font-extrabold text-rose-600 mt-2">{{ $totalCats }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Adopted Cats</h3>
                    <p class="text-5xl font-extrabold text-green-500 mt-2">{{ $adoptedCats }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Happy Adopters</h3>
                    <p class="text-5xl font-extrabold text-yellow-500 mt-2">{{ $happyAdopters }}</p>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-10">
                <h2 class="text-2xl font-bold text-gray-800">Ready to Adopt?</h2>
                <p class="text-lg text-gray-600 mt-2">Browse all our available cats and find your perfect match!</p>
                <a href="{{ route('cats.index') }}" class="inline-block mt-5 px-8 py-3 text-white bg-rose-600 hover:bg-rose-700 rounded-full font-medium text-lg shadow-lg transform transition-all hover:scale-105 no-underline !no-underline">
                    Explore Cats
                </a>
            </div>
        </div>
    </div>
</x-app-layout>