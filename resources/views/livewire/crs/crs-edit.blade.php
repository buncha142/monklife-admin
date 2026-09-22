<div>
    <x-slot name="title">
        {{ __('crs') }}
    </x-slot>
    <!-- Navbar -->
    <x-slot name="nav">
        @include('layouts.navigation-cars')
    </x-slot>
    <section>
        @include('livewire.crs.partials.form', ['title' => 'แก้ไขรายการจองรถ'])
    </section>
    <x-slot name="footer">
        @include('layouts.footer-cars')
    </x-slot>
</div>
