<div>
    <x-slot name="title">
        {{ __('ntfy') }}
    </x-slot>
    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-ntfy')
    </x-slot>
    <section>
        <!-- Content -->
        <x-auth-card>
            <x-slot name="logo">
                <h1 class="text-xl text-blue-800 mt-3">เพิ่มรายการแจ้งเตือน</h1>
            </x-slot>
            <form wire:submit.prevent="save" class="pb-5">
                @csrf
                <!-- หัวข้อ -->
                <div class="mt-2">
                    <div class="inline-flex">
                        <x-label for="title" :value="__('หัวข้อ')" />
                        <p class="ml-1 align-top text-red-600">*</p>
                    </div>
                    <x-input id="title" class="form-input block mt-1 w-full" type="text" name="title"
                        wire:model="title" autofocus placeholder="ภารกิจ..." />
                    <x-input-error-default for="title" />
                </div>
                <!-- รายละเอียดเพิ่มเติม -->
                <div class="mt-2">
                    <x-label for="car_id" :value="__('รายละเอียดเพิ่มเติม(ถ้ามี)')" />
                    <x-input-textarea id="title" class="block mt-1 w-full" wire:model="title" type="text"
                        name="title" />
                    <x-input-error-default for="car_id" />

                </div>

                <!-- ผู้รับบุญ -->
                <div class="mt-2">
                    <x-label for="passenger" :value="__('ผู้รับบุญ(ถ้ามี)')" />
                    <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox"
                        class="w-full mt-1 text-gray-800 bg-gray-50 hover:bg-gray-200 border border-gray-300 focus:ring-2 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex justify-between items-center "
                        type="button">เลือกผู้รับบุญ<svg class="w-4 h-4" aria-hidden="true" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div wire:ignore id="dropdownDefaultCheckbox"
                        class="hidden z-10 w-52  sm:w-full  sm:max-w-sm bg-gray-50 rounded divide-y divide-gray-200 shadow ">
                        <ul class="p-3 space-y-3 text-sm text-gray-700 " aria-labelledby="dropdownCheckboxButton">
                            @foreach ($users as $user)
                                <li wire:key="{{ $user->id }}">
                                    <div class="flex items-center">
                                        <input wire:model.blur="passenger" id="checkbox-item-1" type="checkbox"
                                            value="{{ $user->nickname }}"
                                            class="w-4 h-4 text-blue-900 bg-gray-100 rounded border-blue-900 focus:ring-blue-500  focus:ring-2 ">
                                        <label for="checkbox-item-1" class="ml-2 text-sm font-medium text-blue-900 ">
                                            {{ $user->nickname }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <x-input-error-default for="passenger" />
                    <div class="inline-flex gap-1 mt-1 text-orange-700">
                        @foreach ($passenger as $data)
                            <p wire:key="{{ $data }}">{{ $data }},</p>
                        @endforeach
                    </div>
                </div>

                <x-label for="image" :value="__('ภาพ(ถ้ามี)')" />
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span
                                    class="font-semibold">กดเพื่ออัพโหลด</span> หรือลากวาง</p>
                            <p class="text-xs text-gray-500">ประเภทไฟล์ SVG, PNG, JPG or GIF</p>
                        </div>
                        <input id="dropzone-file" wire:model="image" type="file" class="hidden" />
                    </label>
                </div>
                <x-input-error-default for="image" />
                @if($image)
                <div class="relative block">
                  <img class="object-cover mx-auto rounded-lg h-auto max-w-full " src="{{ $image->temporaryUrl() }}" alt="Avatar">
                </div>
                @endif




                <!-- วันเวลา -->
                <div class="mt-2">
                    <div class="inline-flex">
                        <x-label for="published_at" :value="__('วันเวลาแจ้งเตือน')" />
                        <p class="ml-1 align-top text-red-600">*</p>
                    </div>
                    <div class="relative max-w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input wire:model="published_at" type="datetime-local"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 ">
                    </div>
                    <x-input-error-default for="published_at" />
                </div>

                @role('Admin')
                    <!-- ผู้แจ้ง -->
                    <div wire:ignore class="mt-2">
                        <x-label for="user_id" :value="__('ผู้แจ้ง')" />
                        <x-select class="form-select block mt-1 w-full" type="text" wire:model="user_id" autofocus>
                            @foreach ($users as $user)
                                <option wire:key="{{ $user->id }}" value="{{ $user->id }}">{{ $user->nickname }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error-default for="user_id" />
                    </div>
                @endrole

                <label class="relative mt-2 inline-flex items-center cursor-pointer">
                    <input wire:model="is_active" type="checkbox" value="is_active" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300  rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all  peer-checked:bg-blue-600">
                    </div>
                    <span class="ml-3 text-sm font-medium text-green-600 ">แจ้งบน Line App</span>
                </label>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="w-full text-center">
                        {{ __('ยืนยัน') }}
                    </x-button>
                </div>
            </form>
        </x-auth-card>
    </section>
    <x-slot name="footer">
        @include('layouts.footer-ntfy')
    </x-slot>
</div>
