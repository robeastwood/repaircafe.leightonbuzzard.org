<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="flex-1 text-left">
                <div class="flex items-center">
                    <i class="text-gray-800 text-3xl far fa-calendar-days mr-4"></i>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __("Event Diary") }}
                    </h2>
                </div>
            </div>
            <div class="flex-1 text-right">
                <button class="bg-green-300 hover:bg-green-400 text-green-800 font-bold py-2 px-4 rounded-full">
                    <i class="far fa-calendar-plus mr-2"></i>
                    <span>Add Event</span>
                </button>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:event-list />
        </div>
    </div>
</x-app-layout>
