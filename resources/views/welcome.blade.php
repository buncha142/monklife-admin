<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/png" sizes="192x192" href="/image-logo/logo/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="/image-logo/logo/android-chrome-512x512.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/image-logo/logo/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/image-logo/logo/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/image-logo/logo/favicon-16x16.png">

  <title>{{ config('app.name', 'MonklifeApp') }}</title>

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- tailwindcss -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- flowbite -->
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />

  <!-- Fonts -->
  <link rel="stylesheet" type="text/css" href="/css/style.css">

  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


</head>

<body>


  <!-- Page Container -->
  <div class="flex items-center justify-center sm:min-h-screen bg-white sm:py-32 py-24">
    <div class="flex flex-col">

      <!-- Error Container -->
      <div class="flex flex-col items-center">
        <div class="block relative min-w-max sm:max-h-40">
          <img class=" sm:h-40 h-20  mx-auto object-cover rounded-full "
            src="/logo.png"
            alt="Avatar">
        </div>

        <div class="text-center space-y-4 font-bold text-3xl xl:text-7xl lg:text-6xl md:text-5xl mt-10 text-indigo-800">
         <p>ยินดีต้อนรับสู่</p><p>Monklife Application</p>
        </div>

        <div class="w-full max-w-2xl mt-7 gap-2 inline-flex justify-around ">


        @if (Route::has('login'))
          @auth
          <a href="{{ url('/dashboard') }}"
            class="relative  inline-flex items-center justify-center p-0.5 overflow-hidden text-xl font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-cyan-200 ">
            <span
              class="relative  px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-opacity-0">
              {{ __('เข้าหน้าหลัก') }}
            </span>
          </a>
          @else
          <a href="{{ route('login') }}"
            class="relative  inline-flex items-center justify-center p-0.5 overflow-hidden text-xl font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-cyan-200 ">
            <span
              class="relative  px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-opacity-0">
              {{ __('เข้าสู่ระบบ') }}
            </span>
          </a>
          @if (Route::has('register'))
          <a href="{{ route('register') }}"
            class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-xl font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white  focus:ring-4 focus:outline-none focus:ring-pink-200 ">
            <span
              class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-opacity-0">
              {{ __('ลงทะเบียน') }}
            </span>
          </a>
          @endif
        @endauth
        @endif
        </div>
      </div>
    </div>
  </div>



  <!-- flowbite -->
  <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>

  <!--- jquery --->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




</body>

</html>
