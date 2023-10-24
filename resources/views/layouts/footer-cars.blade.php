<div class="relative">
  <footer class="fixed bottom-0 left-0 right-0">
    <div class="flex flex-row items-center justify-around bg-gray-50  shadow ">
      <!-- จองรถ -->
      <x-nav-link-footer href="{{ route('crs-create') }}"  :active="request()->routeIs('crs-create')">
        <div class="flex items-top justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
                    </div>
        <h3 class=" text-center items-baseline mt-1 text-md  font-semibold">
          จองรถ </h3>
      </x-nav-link-footer>
      <!-- /จองรถ -->
    </div>
  </footer>
</div>
