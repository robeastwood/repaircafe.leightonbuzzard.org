<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center">
            <div class="flex-1 text-left">
                <div class="flex items-center">
                    <i class="text-gray-800 text-lg md:text-3xl fas fa-wrench mr-4"></i>
                    <h2 class="font-semibold text-lg sm:text-2xl md:text-3xl text-gray-800 leading-tight">
                        <p class="text-sm">Repair Cafe Event</p>
                        {{ Carbon\Carbon::parse($event->starts_at)->format('l jS \\of F') }}
                    </h2>
                </div>
            </div>
            <div class="flex-2 text-right">
                <h2 class="font-semibold text-lg sm:text-2xl md:text-3xl text-gray-800 leading-tight">
                    Event Check In
                </h2>
            </div>
        </div>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white sm:rounded-xl shadow-md p-4 mb-4">
                @livewire('checkin-page', ['event' => $event])
            </div>
        </div>
    </div>
</x-app-layout>
