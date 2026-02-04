<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styling -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div></div>
                        <div class="flex">
                            <!-- Navigation Links -->
                            <div class="hidden sm:flex sm:items-center sm:ms-6">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            Sign In
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('login')">
                                            {{ __('Login') }}
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('register')">
                                            {{ __('Signup') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
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
            </main>
        </div>
    </body>
</html>