<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? config('app.name') . ' | ' . strtoupper($title) : config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="192x192"
        href="/image-logo/{{ isset($title) ? $title : 'logo' }}/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512"
        href="/image-logo/{{ isset($title) ? $title : 'logo' }}/android-chrome-512x512.png">
    <link rel="apple-touch-icon" sizes="180x180"
        href="/image-logo/{{ isset($title) ? $title : 'logo' }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="/image-logo/{{ isset($title) ? $title : 'logo' }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="/image-logo/{{ isset($title) ? $title : 'logo' }}/favicon-16x16.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400&family=Sriracha&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>

    <!-- Fontawesome -->
    <link rel="stylesheet"
        href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
        crossorigin="anonymous" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Styles wire-elements/modal -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Scripts wire-elements/modal -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body onload="startTime()">

    <!-- Nav bar -->
    {{ $nav ?? '' }}

    <div class="flex justify-center mx-auto mt-2 pb-24">
        <div class="pt-3 px-2 mx-auto max-w-7xl  w-full ">
            <div
                class="bg-gray-50 py-4 px-2 min-h-screen shadow-sm sm:rounded-lg border-b border-gray-200 text-blue-900">
                {{ $slot }}
            </div>
        </div>
    </div>
    <footer class="mt-auto">
        {{ $footer ?? '' }}
    </footer>

    <!-- wire-elements/modal -->
    @livewire('livewire-ui-modal')

    <!-- livewire -->
    @livewireScripts

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />

    <!-- flowbite -->
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>

    <!-- flowbite -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

    <!-- Show password -->
    <script src="/js/show-password.js"></script>

    <!-- clock.js -->
    <script src="/js/clock.js"></script>

    @stack('modals')


</body>

</html>
