<div>

    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-index')
    </x-slot>

    <!-- Content -->
    <x-auth-card>
        <x-slot name="logo">
            <h1 class="text-xl text-blue-800">แก้ไขข้อมูล</h1>
        </x-slot>


        <form wire:submit.prevent="save" class=" pb-4">
            @csrf

            <div class="flex justify-center">
                <div class="block relative">
                    <img class="h-36 w-36  mx-auto object-cover rounded-lg  "
                        src="{{ $avatar ? Storage::url($avatar) : '/image-components/user.png' }}" alt="Avatar">
                </div>
            </div>


            <!-- ชื่อ -->
            <div class="mt-2">
                <x-label for="name" :value="__('ชื่อ')" />

                <x-input id="name" disabled class="form-input block mt-1 w-full" type="text" name="name"
                    wire:model="name" autofocus />
                <x-input-error-default for="name" />

            </div>

            <!-- นามสกุล -->
            <div class="mt-2">
                <x-label for="surname" :value="__('นามสกุล')" />

                <x-input id="surname" disabled class="form-input block mt-1 w-full" type="text" name="surname"
                    wire:model="surname" autofocus />
                <x-input-error-default for="surname" />

            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <div class="inline-flex"><i class="text-blue-700 fas fa-solid fa-envelope"></i>&nbsp;
                    <x-label for="email" :value="__('E-mail')" />
                </div>
                <p class="text-xs">(สำหรับเข้าระบบ)</p>
                <x-input id="email" disabled class="form-input block mt-1 w-full" type="email" name="email"
                    wire:model="email" required />
                <x-input-error-default for="email" />

            </div>



            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('รหัสผ่าน')" />
                <p class="text-xs">(ตัวเลขหรือตัวอักษรอย่างน้อย 8 ตัว)</p>
                <x-text-input wire:model.defer="password" id="password" class="block mt-1 w-full" type="password"
                    name="password" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- ยืนยัน รหัสผ่าน -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('ยืนยัน รหัสผ่าน')" />

                <x-text-input wire:model.defer="password_confirmation" id="password_confirmation"
                    class="block mt-1 w-full" type="password" name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center mt-2 mb-4">
                <input onclick="myFunction()" type="checkbox"
                    class="w-4 h-4 text-blue-600  rounded border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                <label for="password" class="ml-2 text-sm font-medium text-gray-900">
                    แสดงรหัสผ่าน</label>
            </div>

            <div class="flex  items-center justify-end mt-4">

                <x-button class="w-full text-center">
                    {{ __('ยืนยัน') }}
                </x-button>
            </div>

        </form>

    </x-auth-card>

    <x-slot name="footer">
        @include('layouts.footer-index')
    </x-slot>

</div>
