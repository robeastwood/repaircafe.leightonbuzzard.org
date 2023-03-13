<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-top">
            <div class="flex-1 text-left">
                <div class="flex items-center">
                    <i class="text-gray-800 text-lg md:text-3xl fas fa-wrench mr-4"></i>
                    <h2 class="font-semibold text-lg sm:text-2xl md:text-3xl text-gray-800 leading-tight">
                        {{ Carbon\Carbon::parse($event->starts_at)->format('l jS \\of F') }}
                    </h2>
                </div>
            </div>
            <div class="flex-2 text-right">
                <h2 class="font-semibold text-base sm:text-lg md:text-xl text-gray-800 leading-tight">
                    {{ Carbon\Carbon::parse($event->starts_at)->format('g:i A') }}
                    -
                    {{ Carbon\Carbon::parse($event->ends_at)->format('g:i A') }}
                </h2>
                <div x-data="{ showVenue: false }">
                    <span class="font-semibold text-gray-500">
                        {{ $event->venue->name }}
                    </span>
                    <i class="text-gray-500 text-sm fas fa-circle-info hover:text-gray-800 hover:cursor-pointer"
                        @click="showVenue = !showVenue"></i>

                    <div x-show="showVenue" @click.away="showVenue = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                        class="mt-2">
                        {{ $event->venue->description }}
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white sm:rounded-xl shadow-md p-4 mb-4">

                <div class="flex items-top">
                    <div class="flex-1 text-left">
                        @livewire('volunteers-and-skills', ['event' => $event])
                    </div>
                    <div class="flex-1 text-right">
                        @livewire('attending-button', ['event' => $event])
                    </div>
                </div>

            </div>

            <div class="bg-white sm:rounded-xl shadow-md p-4 mb-4">

                @livewire('item-list', ['items' => $event->items,'event'=>$event])

            </div>
        </div>
    </div>
</x-app-layout>
