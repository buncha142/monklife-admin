@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex flex-col justify-items-center  min-w-fit text-left  items-center border-b-2 border-indigo-400 text-sm font-medium leading-5 text-blue-800 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'flex flex-col justify-items-center py-2 min-w-fit text-left text-blue-700 bg-gray-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>