<x-app-layout>

    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-index')
    </x-slot>

    <section>
        <div class="max-w-screen-md pt-4 mx-auto text-center">
            <h2 class="text-2xl font-extrabold tracking-tight text-blue-800">ยินดีต้อนรับ</h2>
        </div>
        <div
            class="flex items-center w-full max-w-md mx-auto bg-gray-100 rounded-lg shadow max-h-36 min-h-max sm:max-w-md">

            <div class="relative block min-w-max max-h-36">
                <img class="object-cover mx-auto rounded-l-lg h-36 w-36"
                    src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : '/image-components/user.png' }}"
                    alt="Avatar">
            </div>
            <div class="w-full px-3 text-sm font-light text-blue-700 sm:w-64 whitespace-nowrap ">
                <p class="text-xl font-bold tracking-tight">
                    {{ Auth::user()->status }}{{ Auth::user()->name }} {{ Auth::user()->surname }} <font
                        class="text-sm font-light">({{ Auth::user()->nickname }})</font>
                </p>
                <div class="grid grid-cols-2">
                    <p class="text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap">
                            <i class="text-pink-500 fas fad fa-birthday-cake"></i>&nbsp;
                            {{ Auth::user()->dob ? Carbon\Carbon::parse(Auth::user()->dob)->thaidate('j M') : '' }} </a>
                    </p>
                    @if (Auth::user()->status == 'พระ')
                        <p class="text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap">
                                <i class="text-orange-700 fas fa-dharmachakra"></i>&nbsp;
                                {{ Auth::user()->dob ? Carbon\Carbon::parse(Auth::user()->doo)->thaidate('j M Y') : '' }}
                            </a></p>
                    @endif
                </div>
                <p class="col-span-6 text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap"
                        href="mailto:{{ Auth::user()->email }}" target="_blank">
                        <i class="text-blue-700 fas fa-solid fa-envelope"></i>&nbsp; {{ Auth::user()->email }} </a></p>
                <p class="col-span-6 text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap"
                        href="tel:{{ Auth::user()->phone }}" target="_blank">
                        <i class="text-blue-700 fas fa-phone-square-alt"></i>&nbsp; {{ Auth::user()->phone }} </a></p>
                <p class="col-span-6 text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap"
                        href="http://line.me/ti/p/~{{ Auth::user()->line_id }}" target="_blank">
                        <i class="text-green-500 fab fa-line"></i>&nbsp; {{ Auth::user()->line_id }}</a></p>
                <div class="relative justify-end block items-top">
                    <a href="{{ route('member-edit') }}"
                        class="absolute bottom-0 right-0 text-sm text-red-600">แก้ไข-></a>
                </div>
            </div>
        </div>
    </section>

    <!-- hr -->
    <div class="flex justify-center">
        <x-hr-default class="w-2/6 bg-blue-500" />
    </div>

    <section>

        <p class="text-xl font-extrabold text-center text-blue-700">โปรแกรม Monklife App.</p>
        <p class="text-base text-center text-blue-500">ท่านสามารถเลือกโปรแกรมได้ดังนี้</p>

        <div class="flex flex-wrap items-start justify-center gap-1 sm:gap-3">
            <!-- เจ้าหน้าที่ -->
            @can('สมาชิก')
                <a href="{{ route('member-lists') }}"
                    class="inline-flex items-center justify-start w-full min-w-full my-3 bg-gray-200 rounded-lg shadow sm:min-w-0 max-h-24 sm:w-64 md:w-3/12 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300">
                    <div class="block w-24 h-24 min-w-max">
                        <img class="object-cover w-24 h-24 rounded-l-lg" src="/image-logo/member/apple-touch-icon.png"
                            alt="Avatar">
                    </div>
                    <div class="ml-3 text-left ">
                        <p class="-mt-1 text-lg font-extrabold ">สมาชิก</p>
                        <p class="mb-1 overflow-hidden text-base whitespace-wrap text-ellipsis">ข้อมูลเจ้าหน้าที่ภายในศูนย์ฯ
                        </p>
                    </div>
                </a>
            @endcan
            <!-- /เจ้าหน้าที่ -->
            <!-- จองรถ -->
            @can('จองรถ')
                <a href="{{ route('crs-lists') }}"
                    class="inline-flex items-center justify-start w-full min-w-full my-3 bg-gray-200 rounded-lg shadow sm:min-w-0 max-h-24 sm:w-64 md:w-3/12 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300">
                    <div class="block w-24 h-24 min-w-max">
                        <img class="object-cover w-24 h-24 rounded-l-lg" src="/image-logo/crs/apple-touch-icon.png"
                            alt="Avatar">
                    </div>
                    <div class="ml-3 text-left">
                        <p class="-mt-1 text-lg font-extrabold ">จองรถ</p>
                        <p class="mb-1 overflow-hidden text-base whitespace-wrap text-ellipsis">
                            สำหรับเจ้าหน้าที่จองใช้รถศูนย์ฯ
                        </p>
                    </div>
                </a>
            @endcan
            <!-- /จองรถ -->

            <!-- แจ้งเตือน -->
            @can('แจ้งเตือน')
                <a href="{{ route('ntfy-lists') }}"
                    class="inline-flex items-center justify-start w-full min-w-full my-3 bg-gray-200 rounded-lg shadow sm:min-w-0 max-h-24 sm:w-64 md:w-3/12 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300">
                    <div class="block w-24 h-24 min-w-max">
                        <img class="object-cover w-24 h-24 rounded-l-lg" src="/image-logo/ntfy/apple-touch-icon.png"
                            alt="Avatar">
                    </div>
                    <div class="ml-3 text-left ">
                        <p class="-mt-1 text-lg font-extrabold ">แจ้งเตือน</p>
                        <p class="mb-1 overflow-hidden text-base whitespace-wrap text-ellipsis">แจ้งภารกิจให้สมาชิก</p>
                    </div>
                </a>
            @endcan
            <!-- /แจ้งเตือน -->
        </div>
    </section>

    <!-- /ยินดีต้อนรับ -->

    <div class="flex justify-center">
        <x-hr-default class="w-2/6 bg-blue-500" />
    </div>

    <x-slot name="footer">
        @include('layouts.footer-index')
    </x-slot>

</x-app-layout>
