<div class="relative">
  <footer class="fixed bottom-0 left-0 right-0">
    <div class="flex flex-row items-center justify-around bg-gray-50  shadow ">

      <!-- Home Card -->
      <x-nav-link-footer href="/members"  :active="request()->routeIs('member-lists')">
        <div class="flex items-top justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            </path>
          </svg>
        </div>

        <h3 class=" text-center items-baseline mt-1 text-xs font-semibold">สมาชิก</h3>
      </x-nav-link-footer>
      <!-- /Home Card -->




    </div>
  </footer>

</div>
