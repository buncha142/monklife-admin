<div>
    <x-slot name="title">
        {{ __('crs') }}
    </x-slot>
    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-cars')
    </x-slot>
    <section>
        <!-- Content -->
        <x-auth-card>
            <x-slot name="logo">
                <h1 class="text-xl text-blue-800 mt-3">เพิ่มรายการจองรถ</h1>
            </x-slot>
            <form wire:submit.prevent="save" class=" pb-5">
                @csrf
                <!-- ภาระกิจ -->
                <div class="mt-2">
                    <x-label for="name" :value="__('ภาระกิจ')" />
                    <x-input id="name" class="form-input block mt-1 w-full" type="text" name="name"
                        wire:model="name" autofocus placeholder="ภารกิจ..." />
                    <x-input-error-default for="name" />
                </div>
                <!-- รถ -->
                <div class="mt-2">
                    <x-label for="car_id" :value="__('รถ')" />
                    <x-select id="car_id" class="form-select block mt-1 w-full" type="text" name="car_id"
                        wire:model="car_id" autofocus>
                        @foreach ($cars as $car)
                            <option wire:key="{{ $car->id }}" value="{{ $car->id }}">{{ $car->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error-default for="car_id" />
                </div>
                <!-- คนขับ -->
                <div class="mt-2">
                    <x-label for="driver_id" :value="__('คนขับ')" />
                    <x-select class="form-select block mt-1 w-full" type="text" wire:model="driver_id" autofocus>
                        @foreach ($dirvers as $dirver)
                            <option wire:key="{{ $dirver->id }}" value="{{ $dirver->id }}">{{ $dirver->user->nickname }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error-default for="dirver_id" />
                </div>
                @role('Admin')
                    <!-- ผู้จอง -->
                    <div class="mt-2">
                        <x-label for="user_id" :value="__('ผู้จอง')" />
                        <x-select class="form-select block mt-1 w-full" type="text" wire:model="user_id" autofocus>
                            @foreach ($users as $user)
                                <option  wire:key="{{ $user->id }}" value="{{ $user->id }}">{{ $user->nickname }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error-default for="user_id" />
                    </div>
                @endrole
                <!-- ผู้โดยสาร -->
                <div class="mt-2">
                    <x-label for="passenger" :value="__('ผู้โดยสาร')" />
                    <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox"
                        class="w-full mt-1 text-gray-800 bg-gray-50 hover:bg-gray-200 border border-gray-300 focus:ring-2 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex justify-between items-center "
                        type="button">เลือกผู้โดยสาร<svg class="w-4 h-4" aria-hidden="true" fill="none"
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
                            <p wire:key="{{ $data }}" >{{ $data }},</p>
                        @endforeach
                    </div>
                </div>
                <!-- 	ประเภท -->
                <x-label class="my-2 " for="travel" :value="__('การเดินทาง')" />
                <div class="flex justify-around gap-1">
                    <div class="flex items-center gap-1">
                        <x-radio wire:model.live="travel" value="0" />
                        <span for="travel"
                            class="bg-green-100 text-green-900 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded whitespace-nowrap">
                            {{ __('ไป-กลับ') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-radio wire:model.live="travel" value="1" />
                        <span for="travel"
                            class="bg-yellow-100 text-yellow-900 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded whitespace-nowrap">
                            {{ __('ค้างคืน') }}
                        </span>
                    </div>
                </div>
                <!-- 	/ประเภท -->
                <div class="grid grid-cols-2 mt-2 sm:gap-2 gap-1">
                    <!-- วันที่ไป -->
                    <div class="{{ $travel == 0 ? 'col-span-2' : 'col-span-1' }}">
                        <x-label for="start_date" :value="__('วันเดินทาง')" />
                        <x-input id="start_date" class="form-input block mt-1 w-full" type="date" name="start_date"
                            wire:model="start_date" autofocus />
                        <x-input-error-default for="start_date" />
                    </div>
                    <!-- เวลาไป -->
                    <div>
                        <x-label for="start_time" :value="__('เวลาเดินทาง')" />
                        <x-input id="start_time" class="form-input block mt-1 w-full" type="time" name="start_time"
                            wire:model="start_time" autofocus />
                        <x-input-error-default for="start_time" />
                    </div>
                    <!-- วันที่กลับ -->
                    <div class=" {{ $travel == 0 ? 'hidden' : '' }}">
                        <x-label for="end_date" :value="__('วันกลับ')" />
                        <x-input id="end_date" class="form-input block mt-1 w-full" type="date" name="end_date"
                            wire:model="end_date" autofocus />
                        <x-input-error-default for="end_date" />
                    </div>
                    <!-- เวลากลับ -->
                    <div>
                        <x-label for="end_time" :value="__('เวลากลับ')" />
                        <x-input id="end_time" class="form-input block mt-1 w-full" type="time" name="end_time"
                            wire:model="end_time" autofocus />
                        <x-input-error-default for="end_time" />
                    </div>
                </div>
                <!-- ภาระกิจ -->
                <div class="mt-2">
                    <x-label for="description" :value="__('รายละเอียดเพิ่มเติม')" />
                    <x-input-textarea id="description" class="form-input block mt-1 w-full" type="text"
                        name="description" wire:model="description" autofocus placeholder="รายละเอียดเพิ่มเติม..." />
                    <x-input-error-default for="description" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-button class="w-full text-center">
                        {{ __('ยืนยัน') }}
                    </x-button>
                </div>
            </form>
        </x-auth-card>
    </section>
    <x-slot name="footer">
        @include('layouts.footer-cars')
    </x-slot>
</div>
