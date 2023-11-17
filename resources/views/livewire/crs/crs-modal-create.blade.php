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
                    <font class=" text-blue-800">{{ $date->thaidate('d M') }} </font>นี้ มีรายการจองคือ :
                </p>
                <ul class="space-y-1 my-2 text-blue-500 text-xl list-disc list-inside">
                    @foreach ($lists as $list)
                        <li>
                            {{ $list->name . ' เวลา: ' . $list->start_time->format('H:i') . ' ถึง ' . $list->end_time->format('H:i') . ' น. ผู้จอง: ' . $list->user->nickname }}
                        </li>
                    @endforeach
                </ul>
                <p>เพื่อความถูกต้องกรุณาตรวจสอบยืนยันว่าเวลาไม่ทับซ้อนกัน</p>
                <p class="text-blue-500 text-xl mt-2">(คุณจองเวลา : {{ $start_time . ' ถึง ' . $end_time . ' น.' }})</p>
            </div>
        </x-slot>
        <x-slot name="buttons">
            <button type="button" wire:loading.attr="disabled" wire:loading.class="opacity-50"
                wire:click="$dispatch('closeModal')"
                class="focus:outline-none w-full text-blue-800 bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2 ">
                <svg wire:loading aria-hidden="true" class="w-7 h-7 mr-4 text-gray-200 animate-spin fill-blue-500"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>

                {{ __('แก้ไข') }}
            </button>
            <button type="button"  wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:click="$dispatchTo('crs.crs-create', 'store')"
                class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2  focus:outline-none ">
                <svg wire:loading aria-hidden="true" class="w-7 h-7 mr-4 text-gray-200 animate-spin fill-blue-500"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                {{ __('ยืนยัน') }}
            </button>
        </x-slot>
    </x-modal-wire-elements>
</div>
