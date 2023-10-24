<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('รหัสผ่าน') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <!-- แสดงรหัสผ่าน -->
            <div class="flex items-center mt-2 mb-4">
                <input onclick="myFunction()" type="checkbox"
                    class="w-4 h-4 text-blue-600  rounded border-gray-500 focus:ring-blue-500  focus:ring-2 ">
                <label for="password" class="ml-2 text-sm font-medium text-gray-900">
                    แสดงรหัสผ่าน</label>
            </div>


            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" class="text-blue-600  rounded border-gray-500 focus:ring-blue-500  focus:ring-2" name="remember" />
                    <span class="ml-2 text-sm text-gray-900">{{ __('จำไว้ในระบบ') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('คุณลืมรหัสผ่านหรือไม่ ?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('เข้าสู่ระบบ') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
