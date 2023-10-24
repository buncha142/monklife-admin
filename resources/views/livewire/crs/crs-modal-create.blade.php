<div>
    <x-modal-wire-elements>
        <x-slot name="title">
            <div class="py-2 text-2xl">
                {{ __('ยืนยันการจองรถ') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="text-xl pb-6  text-[#0a3b66]">
                <p>เนื่องจากวัน<font class=" text-blue-800">{{ $date->thaidate('l') }} </font>ที่
                    <font class=" text-blue-800">{{ $date->thaidate('d M') }} </font>นี้ มีรายการจองคือ :</p>
                    <ul class="space-y-1 my-2 text-blue-500 text-xl list-disc list-inside">
                        @foreach ($lists as $list)
                        <li>
                            {{ $list->name.' เวลา: '.$list->start_time->format('H:i').' ถึง '.$list->end_time->format('H:i').' น. ผู้จอง: '.$list->user->nickname }}
                        </li>
                        @endforeach
                    </ul>
                <p>เพื่อความถูกต้องกรุณาตรวจสอบยืนยันว่าเวลาไม่ทับซ้อนกัน</p>
                <p class="text-blue-500 text-xl mt-2">(คุณจองเวลา : {{ $start_time.' ถึง '.$end_time.' น.' }})</p>
            </div>
        </x-slot>
        <x-slot name="buttons" >
            <button type="button" wire:click="$dispatch('closeModal')" class="focus:outline-none w-full text-blue-800 bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2 ">แก้ไข</button>
            <button type="button" wire:click="$dispatchTo('crs.crs-create', 'store')"
               class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2  focus:outline-none ">ยืนยัน</button>
        </x-slot>
    </x-modal-wire-elements>
</div>
