@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-rose-500 text-lg font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out no-underline !no-underline'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-lg font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-rose-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out no-underline !no-underline';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>