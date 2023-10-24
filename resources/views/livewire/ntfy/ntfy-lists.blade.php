<div>
    <x-slot name="title">
        {{ __('ntfy') }}
    </x-slot>
    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-ntfy')
    </x-slot>
    <section>
        <div class="w-full sm:max-w-xl mx-auto py-2 ">
            <p class="text-xl font-semibold text-blue-900 ">
                วันนี้ วัน {{ Carbon\Carbon::parse(today())->thaidate('l') }} ที่
                {{ Carbon\Carbon::parse(today())->thaidate('j M y') }} เวลา <span id="txt"
                    class="text-xl font-semibold"></span></p>
            <p class="text-left text-gray-500 ">หมายเหตุ: หากต้องการเพิ่มรายการกรุณาติดต่อ Admin</p>
        </div>

        <div class="min-h-screen   flex flex-row justify-center ">
            <div class="py-3 sm:max-w-xl sm:mx-auto w-full px-2 sm:px-0">

                <div class="relative text-gray-700 antialiased text-sm font-semibold">

                    <!-- Vertical bar running through middle -->
                    <div class="hidden sm:block w-1 bg-blue-300 absolute h-full  transform -translate-x-1/2"></div>

                    <div class="space-y-4">
                        @foreach ($ntfies as $ntfy)
                            <!-- Right section, set by justify-end and sm:pl-8 -->
                            <div class="mt-6 sm:mt-0">
                                <div class="flex flex-col sm:flex-row items-center">
                                    <div class="flex justify-start w-full mx-auto items-center">
                                        <div class="w-full sm:pl-8">
                                            <div class="p-4 bg-white rounded shadow">

                                                <div class="inline-flex items-baseline ">
                                                    <time
                                                        class="mb-1 text-sm font-normal leading-none text-blue-600">{{ $ntfy->published_at->thaidate('l j M y') }}
                                                        เวลา: {{ $ntfy->published_at->thaidate('H:i') }} น.</time>
                                                    <svg class="w-4 h-4 ml-2 self-start text-blue-600 {{ $ntfy->is_active == 1 ? 'hidden' : ' ' }} "
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    <svg class="w-4 h-4 ml-2 self-start text-blue-60 {{ $ntfy->is_active == 0 ? 'hidden' : '' }}"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M15.133 10.632v-1.8a5.407 5.407 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V1.1a1 1 0 0 0-2 0v2.364a.944.944 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C4.867 13.018 3 13.614 3 14.807 3 15.4 3 16 3.538 16h12.924C17 16 17 15.4 17 14.807c0-1.193-1.867-1.789-1.867-4.175Zm-13.267-.8a1 1 0 0 1-1-1 9.424 9.424 0 0 1 2.517-6.39A1.001 1.001 0 1 1 4.854 3.8a7.431 7.431 0 0 0-1.988 5.037 1 1 0 0 1-1 .995Zm16.268 0a1 1 0 0 1-1-1A7.431 7.431 0 0 0 15.146 3.8a1 1 0 0 1 1.471-1.354 9.425 9.425 0 0 1 2.517 6.391 1 1 0 0 1-1 .995ZM6.823 17a3.453 3.453 0 0 0 6.354 0H6.823Z" />
                                                    </svg>
                                                </div>

                                                <h3 class="text-lg font-semibold text-blue-900 ">{{ $ntfy->title }}
                                                </h3>
                                                <article
                                                    class="whitespace-pre-line text-base font-normal text-blue-500 {{ $ntfy->body ? '' : 'hidden' }}">
                                                    {{ $ntfy->body }}
                                                </article>
                                                <p
                                                    class="mb-4 mt-1 text-base font-normal text-blue-500 {{ empty($ntfy->passenger) ? 'hidden' : '' }}">
                                                    <font class=" font-semibold text-blue-600">ผู้รับบุญ :</font>
                                                    {{ implode(', ', $ntfy->passenger) }}
                                                </p>
                                                <img class=" h-auto w-auto {{ empty($ntfy->image) ? 'hidden' : '' }}" src="{{ Storage::url($ntfy->image) }}"
                                                    alt="">


                                                <span wire:click="line({{ $ntfy->id }})"
                                                    class="bg-green-300 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded cursor-pointer"
                                                    onclick="return confirm('{{ __('ยืนยันการส่งไลน์ !') }}') || event.stopImmediatePropagation()"><i
                                                        class="text-green-800 fab fa-line"></i> ส่งไลน์ &nbsp; ->

                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="rounded-full bg-blue-500 border-white border-4 w-8 h-8 absolute  -translate-y-4 sm:translate-y-0 transform -translate-x-1/2 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>


    </section>
    <x-slot name="footer">
        @include('layouts.footer-ntfy')
    </x-slot>
</div>
