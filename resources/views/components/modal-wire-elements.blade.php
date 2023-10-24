@props(['formAction' => false])

<div>
    @if($formAction)
        <form wire:submit.prevent="{{ $formAction }}">
    @endif
            <div class="relative bg-white p-4 sm:px-6 sm:py-4 border-b border-gray-150">
                @if(isset($closeButton))
                <button {{ $attributes }} wire:click="$dispatch('closeModal')" type="button" class="absolute  inset-x-0 top-4 mr-2 text-gray-500 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="defaultModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
                @endif

                @if(isset($title))
                    <h3 class="text-4xl  text-center leading-6 font-medium text-[#0a3b66]">
                        {{ $title }}
                    </h3>
                @endif
            </div>
            <div class="bg-white px-4 sm:p-6 text-[#0a3b66]">
                    {{ $content }}
            </div>

            <div class="px-4 pb-5 sm:px-4 sm:flex justify-center gap-4 text-[#0a3b66]">
                {{ $buttons }}
            </div>
    @if($formAction)
        </form>
    @endif
</div>
