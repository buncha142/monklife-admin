<div>
    <x-slot name="title">
        {{ __('crs') }}
    </x-slot>
    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-cars')
    </x-slot>
    <section>
        <div class="w-full sm:max-w-xl mx-auto py-2 ">
            <p class="text-xl font-semibold text-blue-900 ">
                วันนี้ วัน {{ today()->thaidate('l') }} ที่
                {{ today()->thaidate('j M y') }} เวลา <span id="txt"
                    class="text-xl font-semibold"></span></p>
            <p class="text-left text-gray-500 ">หมายเหตุ: สารถีหยุดทุกวันอาทิตย์</p>
        </div>
        <div class="w-full sm:max-w-xl mx-auto py-5 px-2">
            <ol class="relative border-l border-gray-400 ">
                @foreach ($bookcars as $bookcar)
                    <li class="mb-10 ml-6" wire:key="{{ $bookcar->id }}">
                        <span
                            class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-4 ring-blue-100 ">
                            <svg aria-hidden="true" class="w-3 h-3 text-blue-600" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            @if ($bookcar->start_date->isToday())
                                <img src="{{ asset('image-components/Red_circle.gif') }}" class="absolute w-96 opacity-75" alt="" />
                            @endif

                        </span>
                        <h3 class="flex items-center mb-1 text-xl font-semibold text-blue-900 ">{{ $bookcar->name }}
                        </h3>
                        <p class="block mb-1 text-base font-normal leading-none text-blue-700 ">
                            <font class=" font-bold">เดินทาง:</font>
                            {{ $bookcar->start_date->thaidate('l j M y') }} <font
                                class=" font-bold"> เวลา </font>
                            {{ $bookcar->start_time->format('H:i') . ' น.' }}
                        </p>
                        <p class="block mb-1 text-base font-normal leading-none text-blue-700 ">
                            <font class=" font-bold">กลับ:</font>
                            {{ $bookcar->end_date?->thaidate('j M y') }}
                            <font class=" font-bold"> เวลา </font>
                            {{ $bookcar->end_time?->format('H:i') . ' น.' }}
                        </p>
                        <p class="text-base font-normal text-blue-700  ">
                            <font class=" font-bold">สารถี:</font> {{ $bookcar->driver?->user?->nickname }} | <font
                                class=" font-bold">
                                ผู้จอง: </font> {{ $bookcar->user?->nickname }}
                        </p>
                        <p class=" text-base font-normal text-blue-700  ">
                            <font class=" font-bold">รถ:</font> {{ $bookcar->car?->name }}
                        </p>
                        @if (!empty($bookcar->passenger))
                            <p class="text-blue-700">
                                <font class="font-bold">ผู้เดินทาง:</font>
                                {{ implode(', ', $bookcar->passenger) }}
                            </p>
                        @endif
                        @if ($bookcar->description)
                            <p class="text-base font-normal text-red-500 whitespace-normal">
                                <font class=" font-bold text-blue-700">รายละเอียดเพิ่มเติม: </font>
                                {{ $bookcar->description }}
                            </p>
                        @endif
                        <div class=" flex flex-inline space-x-3 mt-2">
                            @if ($bookcar->user_id == auth()->id() || auth()->user()->hasRole('Admin'))
                                <x-icon-edit href="{{ route('crs-edit', $bookcar->id) }}" />
                                <x-icon-delete wire:click="delete({{ $bookcar->id }})"
                                    class="font-medium ml-2 text-red-600 cursor-pointer"
                                    onclick="return confirm('{{ __('ยืนยันการลบ !') }}') || event.stopImmediatePropagation()" />
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
            @if ($bookcars->isEmpty())
                <p class="text-center text-gray-500">ยังไม่มีรายการจองรถ</p>
            @endif
        </div>
    </section>
    <x-slot name="footer">
        @include('layouts.footer-cars')
    </x-slot>
</div>
