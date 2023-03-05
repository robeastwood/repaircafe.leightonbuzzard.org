<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="flex-1 text-left">
                <div class="flex items-center">
                    <i class="text-gray-800 text-3xl far fa-calendar-days mr-4"></i>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Event Diary') }}
                    </h2>
                </div>
            </div>
            @if (Auth::user()->is_admin)
                <div class="flex-1 text-right">
                    @livewire('create-event')
                </div>
            @endif
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('event-list')
        </div>
    </div>
</x-app-layout>
