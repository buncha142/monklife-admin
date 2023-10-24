<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold sm:text-base text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
