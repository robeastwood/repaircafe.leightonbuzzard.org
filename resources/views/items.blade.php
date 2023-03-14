<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="flex-1 text-left">
                <div class="flex items-center">
                    <i class="text-gray-800 text-3xl fas fa-heart-crack mr-4"></i>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('My Items') }}
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white sm:rounded-xl shadow-md p-4 mb-4">

                <div class="flex items-center">
                    <div class="flex-1 text-left">
                        <div class="flex items-center">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                My Items:
                            </h2>
                        </div>
                    </div>
                    <div class="flex-1 text-right">
                        @livewire('create-item')
                    </div>
                </div>

                @livewire('item-list', ['items' => $items])

            </div>
        </div>
    </div>
</x-app-layout>
