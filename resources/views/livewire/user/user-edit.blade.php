<div>
    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-index')
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <h1 class="text-xl text-blue-800">แก้ไขข้อมูล</h1>
        </x-slot>


        <form wire:submit.prevent="save" class=" pb-20">
            @csrf

            <div class="flex justify-center">
                @if ($photo)
                    <div class="block relative">
                        <img class="h-36 w-36  mx-auto object-cover rounded-lg  " src="{{ $photo->temporaryUrl() }}"
                            alt="Avatar">
                    </div>
                @elseif(empty($avatar))
                    <img class="max-h-36 w-36 rounded-lg  " src="/image-components/user.png" alt="Bonnie Avatar">
                @else
                    <div class="block relative">
                        <img class="h-36 w-36  mx-auto object-cover rounded-lg  " src="{{ Storage::url($avatar) }}"
                            alt="Avatar">
                    </div>
                @endif
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 " for="photo">รูปโปรไฟล์</label>
                <input wire:model="photo"
                    class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none  id="
                    file_input" type="file">
            </div>

            <!-- สถานะ -->
            <div class="mt-2">
                <x-label for="status" :value="__('สถานะ')" />
                <x-select id="status" class="form-select block mt-1 w-full" type="text" name="status"
                    wire:model="status" autofocus>
                    <option value="พระ">พระภิกษุ</option>
                    <option value="อุบาสก">ชาย</option>
                    <option value="อุบาสิกา">หญิง</option>
                </x-select>
                <x-input-error-default for="status" />
            </div>

            <!-- ชื่อ -->
            <div class="mt-2">
                <x-label for="name" :value="__('ชื่อ')" />

                <x-input id="name" class="form-input block mt-1 w-full" type="text" name="name"
                    wire:model="name" autofocus />
                <x-input-error-default for="name" />

            </div>

            <!-- นามสกุล -->
            <div class="mt-2">
                <x-label for="surname" :value="__('นามสกุล')" />

                <x-input id="surname" class="form-input block mt-1 w-full" type="text" name="surname"
                    wire:model="surname" autofocus />
                <x-input-error-default for="surname" />

            </div>

            <!-- ชื่อเล่น -->
            <div class="mt-2">
                <x-label for="nickname" :value="__('ชื่อเล่น')" />
                <p class="text-xs">(ชื่อเรียกกันภายในศูนย์ฯ)</p>
                <x-input id="nickname" class="form-input block mt-1 w-full" type="text" name="nickname"
                    wire:model="nickname" autofocus />
                <x-input-error-default for="nickname" />
            </div>

            <!-- วันเกิด -->
            <div class="mt-2">
                <div class="inline-flex"><i class="text-pink-700 fas fad fa-birthday-cake"></i>&nbsp;<x-label
                        for="dob" :value="__('วัน-เดือน-ปี เกิด')" /></div>
                <x-input id="dob" class="form-input block mt-1 w-full" type="date" name="dob"
                    wire:model="dob" autofocus />
                <x-input-error-default for="dob" />
            </div>

            @if ($status == 1)
                <!-- วันบวช -->
                <div class="mt-2">
                    <div class="inline-flex"><i class=" text-orange-700 fas fa-dharmachakra"></i>&nbsp;<x-label
                            for="doo" :value="__('วัน-เดือน-ปี บวช')" /></div>
                    <x-input id="doo" class="form-input block mt-1 w-full" type="date" name="doo"
                        wire:model="doo" autofocus />
                    <x-input-error-default for="doo" />
                </div>
            @endif

            <!-- Email Address -->
            <div class="mt-4">
                <div class="inline-flex"><i class="text-blue-700 fas fa-solid fa-envelope"></i>&nbsp;<x-label
                        for="email" :value="__('E-mail')" /></div>
                <p class="text-xs">(สำหรับเข้าระบบ)</p>
                <x-input id="email" class="form-input block mt-1 w-full" type="email" name="email"
                    wire:model="email" required />
                <x-input-error-default for="email" />

            </div>

            <!-- เบอร์โทร -->
            <div class="mt-4">
                <div class="inline-flex"><i class="text-blue-700 fas fa-phone-square-alt"></i>&nbsp;<x-label
                        for="phone" :value="__('เบอร์โทร')" /></div>

                <x-input id="phone" class="form-input block mt-1 w-full" type="tel" name="phone"
                    wire:model="phone" />
                <x-input-error-default for="phone" />
            </div>

            <!-- Line ID -->

            <div class="mt-4">
                <div class="inline-flex"><i class="text-green-500 fab fa-line"></i>&nbsp;<x-label for="line_id"
                        :value="__('Line ID')" /></div>

                <x-input id="line_id" class="form-input block mt-1 w-full" type="text" name="line_id"
                    wire:model="line_id" />
                <x-input-error-default for="line_id" />

            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="w-full text-center">
                    {{ __('ยืนยัน') }}
                </x-button>
            </div>
            <a href="{{ route('member-edit-password', $dataId) }}" type="button"
                class="w-full text-center mt-4 px-4 py-2 bg-orange-400 border border-transparent rounded-md font-semibold sm:text-base text-xs text-gray-100 uppercase tracking-widest hover:bg-orange-500 active:bg-orange-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ">
                {{ __('เปลี่ยนพาสเวิร์ด') }}
            </a>
        </form>
    </x-auth-card>
    <x-slot name="footer">
        @include('layouts.footer-index')
    </x-slot>
</div>
