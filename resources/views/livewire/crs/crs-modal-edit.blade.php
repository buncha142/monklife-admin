<div>
    <x-modal-wire-elements>
        <x-slot name="title">
            <div class="py-2 text-2xl">
                {{ __('ยืนยันการจองรถ') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="text-xl pb-6  text-[#0a3b66]">
                <p>คุณได้แก้ไขรายการคือ :<font class=" text-blue-800">{{ $name }} </font></p>
                <p>เดินทางวัน <font class=" text-blue-800">{{ $date->thaidate('l') }} </font>ที่ <font class=" text-blue-800">{{ $date->thaidate('d M') }} </font>นี้</p>

                <p>{{ ' เวลา: '.$start_time.' ถึง '.$end_time.' น.' }}</p>

                <p>เพื่อความถูกต้องกรุณากด "ยืนยัน" ว่าเวลาไม่ทับซ้อนกัน</p>
            </div>
        </x-slot>
        <x-slot name="buttons" >
            <button type="button"  wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:click="$dispatch('closeModal')" class="focus:outline-none w-full text-blue-800 bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2 ">
                {{ __('แก้ไข') }}
            </button>
            <button type="button"  wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:click="$dispatchTo('crs.crs-edit', 'store')"
               class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2  focus:outline-none ">
               {{ __('ยืนยัน') }}
            </button>
        </x-slot>
    </x-modal-wire-elements>
</div>
