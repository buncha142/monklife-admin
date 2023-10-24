<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- icon -->
    <link rel="icon" type="image/png" sizes="192x192" href="/image-logo/logo/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/image-logo/logo/android-chrome-512x512.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/image-logo/logo/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/image-logo/logo/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/image-logo/logo/favicon-32x32.png">

    <title>@yield('title')</title>

    <!-- tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="/css/style.css">


    @livewireStyles

</head>

<body>


    <!-- Page Container -->
    <div class="flex items-center justify-center sm:min-h-screen bg-white sm:py-32 py-24">
        <div class="flex flex-col">

            <!-- Error Container -->
            <div class="flex flex-col items-center">
                <div class="block relative min-w-max sm:max-h-40">
                    <img class=" sm:h-40 h-20  mx-auto object-cover rounded-full " src="/image-logo/logo/android-chrome-512x512.png" alt="Avatar">
                </div>

                <div
                    class="text-center font-bold text-3xl xl:text-7xl lg:text-6xl md:text-5xl sm:mt-10 mt-5 text-indigo-800">
                    MonkLife App.
                </div>

                <div
                    class="text-center text-red-500 font-bold text-3xl xl:text-7xl lg:text-6xl md:text-5xl sm:mt-10 mt-5">
                    Error 404
                </div>


                <div class="text-indigo-800 font-medium text-base md:text-xl lg:text-2xl sm:mt-10 mt-5">
                    @yield('code') | @yield('message')
                </div>
            </div>
        </div>
    </div>
    @livewireScripts

    <!-- flowbite -->
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>


</body>

</html>
