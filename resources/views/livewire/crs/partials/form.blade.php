{{-- ฟอร์มจองรถ ใช้ร่วมกันระหว่าง crs-create และ crs-edit ($title = หัวข้อฟอร์ม) --}}
<x-auth-card>
    <x-slot name="logo">
        <h1 class="text-xl text-blue-800 mt-3">{{ $title }}</h1>
    </x-slot>
    <form wire:submit="save" class="pb-5">
        <!-- ภารกิจ -->
        <div class="mt-2">
            <x-label for="name" :value="__('ภารกิจ')" />
            <x-input id="name" class="form-input block mt-1 w-full" type="text" wire:model="name" autofocus
                placeholder="ภารกิจ..." />
            <x-input-error-default for="name" />
        </div>
        <!-- รถ -->
        <div class="mt-2">
            <x-label for="car_id" :value="__('รถ')" />
            <x-select id="car_id" class="form-select block mt-1 w-full" wire:model="car_id">
                @foreach ($cars as $car)
                    <option wire:key="car-{{ $car->id }}" value="{{ $car->id }}">{{ $car->name }}</option>
                @endforeach
            </x-select>
            <x-input-error-default for="car_id" />
        </div>
        <!-- คนขับ -->
        <div class="mt-2">
            <x-label for="driver_id" :value="__('คนขับ')" />
            <x-select id="driver_id" class="form-select block mt-1 w-full" wire:model="driver_id">
                @foreach ($dirvers as $dirver)
                    <option wire:key="driver-{{ $dirver->id }}" value="{{ $dirver->id }}">{{ $dirver->user?->nickname }}</option>
                @endforeach
            </x-select>
            <x-input-error-default for="driver_id" />
        </div>
        @role('Admin')
            <!-- ผู้จอง -->
            <div class="mt-2">
                <x-label for="user_id" :value="__('ผู้จอง')" />
                <x-select id="user_id" class="form-select block mt-1 w-full" wire:model.live="user_id">
                    @foreach ($users as $user)
                        <option wire:key="user-{{ $user->id }}" value="{{ $user->id }}">{{ $user->nickname }}</option>
                    @endforeach
                </x-select>
                <x-input-error-default for="user_id" />
            </div>
        @endrole
        <!-- ผู้โดยสาร -->
        <div class="mt-2">
            <x-label for="dropdownCheckboxButton" :value="__('ผู้โดยสาร')" />
            <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox"
                class="w-full mt-1 text-gray-800 bg-gray-50 hover:bg-gray-200 border border-gray-300 focus:ring-2 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex justify-between items-center"
                type="button">เลือกผู้โดยสาร<svg class="w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div wire:ignore id="dropdownDefaultCheckbox"
                class="hidden z-10 w-52 sm:w-full sm:max-w-sm max-h-72 overflow-y-auto bg-gray-50 rounded divide-y divide-gray-200 shadow">
                <ul class="p-3 space-y-3 text-sm text-gray-700" aria-labelledby="dropdownCheckboxButton">
                    @foreach ($users->whereNotNull('nickname') as $user)
                        <li wire:key="passenger-{{ $user->id }}">
                            <div class="flex items-center">
                                <input wire:model="passenger" id="passenger-{{ $user->id }}" type="checkbox"
                                    value="{{ $user->nickname }}"
                                    class="w-4 h-4 text-blue-900 bg-gray-100 rounded border-blue-900 focus:ring-blue-500 focus:ring-2">
                                <label for="passenger-{{ $user->id }}" class="ml-2 text-sm font-medium text-blue-900">
                                    {{ $user->nickname }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <x-input-error-default for="passenger" />
            <p class="mt-1 text-orange-700">{{ implode(', ', $passenger) }}</p>
        </div>
        <!-- การเดินทาง -->
        <x-label class="my-2" :value="__('การเดินทาง')" />
        <div class="flex justify-around gap-1">
            <label class="flex items-center gap-1 cursor-pointer">
                <x-radio wire:model.live="travel" value="0" />
                <span
                    class="bg-green-100 text-green-900 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded whitespace-nowrap">
                    {{ __('ไป-กลับ') }}
                </span>
            </label>
            <label class="flex items-center gap-1 cursor-pointer">
                <x-radio wire:model.live="travel" value="1" />
                <span
                    class="bg-yellow-100 text-yellow-900 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded whitespace-nowrap">
                    {{ __('ค้างคืน') }}
                </span>
            </label>
        </div>
        <div class="grid grid-cols-2 mt-2 sm:gap-2 gap-1">
            <!-- วันที่ไป -->
            <div class="{{ $travel == 0 ? 'col-span-2' : 'col-span-1' }}">
                <x-label for="start_date" :value="__('วันเดินทาง')" />
                <x-input id="start_date" class="form-input block mt-1 w-full" type="date" wire:model="start_date" />
                <x-input-error-default for="start_date" />
            </div>
            <!-- วันที่กลับ -->
            <div class="{{ $travel == 0 ? 'hidden' : '' }}">
                <x-label for="end_date" :value="__('วันกลับ')" />
                <x-input id="end_date" class="form-input block mt-1 w-full" type="date" wire:model="end_date" />
                <x-input-error-default for="end_date" />
            </div>
        </div>
        @php
            $chip = 'px-3 py-1 text-sm rounded-full border transition disabled:opacity-40';
            $chipOff = 'bg-gray-50 border-gray-300 text-gray-800 hover:bg-gray-200';
            $chipOn = 'bg-blue-800 border-blue-800 text-white';
        @endphp
        <!-- เวลาไป: ปุ่มลัด + ตัวเลือกทุก 30 นาที -->
        <div class="mt-2">
            <x-label for="start_time" :value="__('เวลาเดินทาง')" />
            <div class="flex flex-wrap gap-1 mt-1">
                @foreach ($this->startPresets() as $time)
                    <button type="button" wire:key="start-{{ $time }}" wire:click="$set('start_time', '{{ $time }}')"
                        class="{{ $chip }} {{ $start_time === $time ? $chipOn : $chipOff }}">{{ $time }}</button>
                @endforeach
            </div>
            <x-select id="start_time" class="form-select block mt-1 w-full" wire:model.live="start_time">
                <option value="">-- เลือกเวลา --</option>
                @foreach ($this->timeSlots() as $time)
                    <option wire:key="start-slot-{{ $time }}" value="{{ $time }}">{{ $time }} น.</option>
                @endforeach
            </x-select>
            <x-input-error-default for="start_time" />
        </div>
        <!-- เวลากลับ: ไป-กลับ = +N ชม. จากเวลาไป, ค้างคืน = เวลาคงที่ -->
        <div class="mt-2">
            <x-label for="end_time" :value="__('เวลากลับ')" />
            <div class="flex flex-wrap gap-1 mt-1">
                @if ($travel == 0)
                    @foreach ($this->durationPresets() as $minutes => $label)
                        <button type="button" wire:key="duration-{{ $minutes }}" wire:click="setDuration({{ $minutes }})"
                            @disabled(!$start_time) class="{{ $chip }} {{ $chipOff }}">{{ $label }}</button>
                    @endforeach
                @else
                    @foreach ($this->endPresets() as $time)
                        <button type="button" wire:key="end-{{ $time }}" wire:click="$set('end_time', '{{ $time }}')"
                            class="{{ $chip }} {{ $end_time === $time ? $chipOn : $chipOff }}">{{ $time }}</button>
                    @endforeach
                @endif
            </div>
            <x-select id="end_time" class="form-select block mt-1 w-full" wire:model.live="end_time">
                <option value="">-- เลือกเวลา --</option>
                @foreach ($this->timeSlots() as $time)
                    <option wire:key="end-slot-{{ $time }}" value="{{ $time }}">{{ $time }} น.</option>
                @endforeach
            </x-select>
            <x-input-error-default for="end_time" />
        </div>
        <!-- รายละเอียดเพิ่มเติม -->
        <div class="mt-2">
            <x-label for="description" :value="__('รายละเอียดเพิ่มเติม')" />
            <x-input-textarea id="description" class="form-input block mt-1 w-full" wire:model="description"
                placeholder="รายละเอียดเพิ่มเติม..." />
            <x-input-error-default for="description" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-button class="w-full justify-center" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                <svg wire:loading wire:target="save" aria-hidden="true"
                    class="w-5 h-5 mr-3 text-gray-200 animate-spin fill-blue-500" viewBox="0 0 100 101" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                {{ __('ยืนยัน') }}
            </x-button>
        </div>
    </form>
</x-auth-card>
