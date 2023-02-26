<div>

    <div x-data="{ isOpen: false }" class="relative inline-block">
        <!-- Dropdown toggle button -->
        @switch($status)
            @case('attending')
                <button @click="isOpen = !isOpen"
                    class="bg-green-300 hover:bg-green-400 text-green-800 font-bold py-2 px-4 rounded-full mb-2 whitespace-nowrap">
                    <i class="far fa-circle-check mr-2"></i>
                    <span>Attending</span>
                </button>
            @break

            @case('volunteering')
                <button @click="isOpen = !isOpen"
                    class="bg-green-300 hover:bg-green-400 text-green-800 font-bold py-2 px-4 rounded-full mb-2 whitespace-nowrap">
                    <i class="fas fa-wrench mr-2"></i>
                    <span>Volunteering</span>
                </button>
            @break

            @default
                <button @click="isOpen = !isOpen"
                    class="bg-red-300 hover:bg-red-400 text-red-800 font-bold py-2 px-4 rounded-full whitespace-nowrap">
                    <i class="far fa-circle-xmark mr-2"></i>
                    <span>Not Attending</span>
                </button>
        @endswitch

        <!-- Dropdown menu -->
        <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="absolute right-0 z-20 px-2 mt-2 origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800">
            @if ($status != 'attending')
                <button wire:click="rsvp('attending'); isOpen = false" @click="isOpen = false"
                    class="bg-green-300 hover:bg-green-400 text-green-800 font-bold py-2 px-4 rounded-full mb-2 whitespace-nowrap">
                    <i class="far fa-circle-check mr-2"></i>
                    <span>Attending</span>
                </button>
            @endif
            @if ($status != 'volunteering')
                <button wire:click="rsvp('volunteering'); isOpen = false" @click="isOpen = false"
                    class="bg-green-300 hover:bg-green-400 text-green-800 font-bold py-2 px-4 rounded-full mb-2 whitespace-nowrap">
                    <i class="fas fa-wrench mr-2"></i>
                    <span>Volunteering</span>
                </button>
            @endif
            @if ($status != 'notattending')
                <button wire:click="rsvp('notattending'); isOpen = false" @click="isOpen = false"
                    class="bg-red-300 hover:bg-red-400 text-red-800 font-bold py-2 px-4 rounded-full mb-2 whitespace-nowrap">
                    <i class="far fa-circle-xmark mr-2"></i>
                    <span>Not Attending</span>
                </button>
            @endif
        </div>
    </div>
</div>
