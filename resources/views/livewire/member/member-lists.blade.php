<div>
    <x-slot name="title">
        {{ __('member') }}
    </x-slot>
    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-member')
    </x-slot>

    <!--- คณะสงฆ์ --->
    <div class="px-8">
        <div class="mx-auto max-w-screen-md text-center pt-4">
            <h2 class="text-2xl tracking-tight font-extrabold text-blue-800">{{ __('คณะสงฆ์') }}</h2>
        </div>

        <div class="flex flex-wrap justify-start py-2  items-center gap-3 mt-3">

            @foreach ($monks as $monk)
                <div wire:key="{{ $monk->id }}"
                    class="items-center  flex  max-h-36 min-h-max  sm:max-w-sm max-w-md w-full bg-gray-100 rounded-lg shadow">

                    <div class="block relative min-w-max max-h-32">
                        <img class="w-32  h-32  object-cover rounded-l-lg"
                            src="{{ $monk->avatar ? Storage::url($monk->avatar) : '/image-components/user.png' }}"
                            alt="Avatar">
                    </div>

                    <div class="px-3 font-light text-sm sm:w-64 w-full text-blue-700 whitespace-nowrap ">
                        <p class="text-xl font-bold tracking-tight truncate">
                            {{ $monk->status . $monk->name . ' ' . $monk->surname }} <font class="font-light text-sm">
                                ({{ $monk->nickname }})
                            </font>
                        </p>


                        <div class="grid grid-cols-2">
                            <p class="text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap">
                                    <i class="text-pink-500 fas fad fa-birthday-cake"></i>&nbsp;
                                    {{ $monk->dob ? Carbon\Carbon::parse($monk->dob)->thaidate('j M') : '' }} </a></p>
                            <p class="text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap">
                                    <i class=" text-orange-700 fas fa-dharmachakra"></i>&nbsp;
                                    {{ $monk->doo ? Carbon\Carbon::parse($monk->doo)->thaidate('j M Y') : '' }} </a></p>
                        </div>

                        <p class="col-span-6 text-sm text-center truncate"><a
                                class="flex flex-row items-center whitespace-nowrap" href="mailto:{{ $monk->email }}"
                                target="_blank">
                                <i class="text-blue-700 fas fa-solid fa-envelope"></i>&nbsp; {{ $monk->email }} </a>
                        </p>
                        <p class="col-span-6 text-sm text-center"><a
                                class="flex flex-row items-center whitespace-nowrap" href="tel:{{ $monk->phone }}"
                                target="_blank">
                                <i class="text-blue-700 fas fa-phone-square-alt"></i>&nbsp; {{ $monk->phone }} </a>
                        </p>
                        <p class="col-span-6 text-sm text-center"><a
                                class="flex flex-row items-center whitespace-nowrap"
                                href="http://line.me/ti/p/~{{ $monk->line_id }}" target="_blank">
                                <i class="text-green-500 fab fa-line"></i>&nbsp; {{ $monk->line_id }}</a></p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-2">
            {{ $monks->links() }}
        </div>
    </div>
    <!--- /คณะสงฆ์ --->

    <!--- อุบาสก --->
    @if (count($upss) != 0)
    <div class="px-8">
        <div class="mx-auto max-w-screen-md text-center pt-4">
            <h2 class="text-2xl tracking-tight font-extrabold text-blue-800">{{ __('อุบาสก') }}</h2>
        </div>
        <div class="flex flex-wrap justify-start py-2  items-center gap-3 mt-3">
            @foreach ($upss as $ups)
                <div wire:key="{{ $ups->id }}"
                    class="items-center  flex  max-h-36 min-h-max  sm:max-w-sm max-w-md w-full bg-gray-100 rounded-lg shadow">
                    <div class="block relative min-w-max max-h-32">
                        <img class="w-32  h-32  object-cover rounded-l-lg"
                            src="{{ $ups->avatar ? Storage::url($ups->avatar) : '/image-components/user.png' }}"
                            alt="Avatar">
                    </div>
                    <div class="px-3 font-light text-sm sm:w-64 w-full text-blue-700 whitespace-nowrap ">
                        <p class="text-xl font-bold tracking-tight truncate">
                            {{ $ups->status . $ups->name . ' ' . $ups->surname }} <font class="font-light text-sm">
                                ({{ $ups->nickname }})
                            </font>
                        </p>
                        <div class="grid grid-cols-2">
                            <p class="text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap">
                                    <i class="text-pink-500 fas fad fa-birthday-cake"></i>&nbsp;
                                    {{ $ups->dob ? Carbon\Carbon::parse($ups->dob)->thaidate('j M') : '' }} </a></p>
                        </div>
                        <p class="col-span-6 text-sm text-center truncate"><a
                                class="flex flex-row items-center whitespace-nowrap" href="mailto:{{ $ups->email }}"
                                target="_blank">
                                <i class="text-blue-700 fas fa-solid fa-envelope"></i>&nbsp; {{ $ups->email }} </a>
                        </p>
                        <p class="col-span-6 text-sm text-center"><a
                                class="flex flex-row items-center whitespace-nowrap" href="tel:{{ $ups->phone }}"
                                target="_blank">
                                <i class="text-blue-700 fas fa-phone-square-alt"></i>&nbsp; {{ $ups->phone }} </a>
                        </p>
                        <p class="col-span-6 text-sm text-center"><a
                                class="flex flex-row items-center whitespace-nowrap"
                                href="http://line.me/ti/p/~{{ $ups->line_id }}" target="_blank">
                                <i class="text-green-500 fab fa-line"></i>&nbsp; {{ $ups->line_id }}</a></p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-2">
            {{ $upss->links() }}
        </div>
    </div>
    @endif
    <!--- /อุบาสก --->

    <!--- อุบาสิกา --->
    @if (count($upks) != 0)
        <div class="px-8">
            <div class="mx-auto max-w-screen-md text-center pt-4">
                <h2 class="text-2xl tracking-tight font-extrabold text-blue-800">{{ __('อุบาสิกา') }}</h2>
            </div>

            <div class="flex flex-wrap justify-start py-2  items-center gap-3 mt-3">

                @foreach ($upks as $upk)
                    <div wire:key="{{ $upk->id }}"
                        class="items-center  flex  max-h-36 min-h-max  sm:max-w-sm max-w-md w-full bg-gray-100 rounded-lg shadow">

                        <div class="block relative min-w-max max-h-32">
                            <img class="w-32  h-32  object-cover rounded-l-lg"
                                src="{{ $upk->avatar ? Storage::url($upk->avatar) : '/image-components/user.png' }}"
                                alt="Avatar">
                        </div>

                        <div class="px-3 font-light text-sm sm:w-64 w-full text-blue-700 whitespace-nowrap ">
                            <p class="text-xl font-bold tracking-tight truncate">
                                {{ $upk->status . $upk->name . ' ' . $upk->surname }} <font class="font-light text-sm">
                                    ({{ $upk->nickname }})
                                </font>
                            </p>
                            <div class="grid grid-cols-2">
                                <p class="text-sm text-center"><a class="flex flex-row items-center whitespace-nowrap">
                                        <i class="text-pink-500 fas fad fa-birthday-cake"></i>&nbsp;
                                        {{ $upk->dob ? Carbon\Carbon::parse($upk->dob)->thaidate('j M') : '' }} </a>
                                </p>
                            </div>
                            <p class="col-span-6 text-sm text-center truncate"><a
                                    class="flex flex-row items-center whitespace-nowrap"
                                    href="mailto:{{ $upk->email }}" target="_blank">
                                    <i class="text-blue-700 fas fa-solid fa-envelope"></i>&nbsp; {{ $upk->email }}
                                </a>
                            </p>
                            <p class="col-span-6 text-sm text-center"><a
                                    class="flex flex-row items-center whitespace-nowrap" href="tel:{{ $upk->phone }}"
                                    target="_blank">
                                    <i class="text-blue-700 fas fa-phone-square-alt"></i>&nbsp; {{ $upk->phone }}
                                </a>
                            </p>
                            <p class="col-span-6 text-sm text-center"><a
                                    class="flex flex-row items-center whitespace-nowrap"
                                    href="http://line.me/ti/p/~{{ $upk->line_id }}" target="_blank">
                                    <i class="text-green-500 fab fa-line"></i>&nbsp; {{ $upk->line_id }}</a></p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-2">
                {{ $upks->links() }}
            </div>
        </div>
    @endif
    <!--- /อุบาสก --->
    <x-slot name="footer">
        @include('layouts.footer-member')
    </x-slot>
</div>
