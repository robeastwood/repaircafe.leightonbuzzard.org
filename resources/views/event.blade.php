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

                <div class="flex items-center">
                    <div class="flex-1 text-left">
                        <div class="flex items-center">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ count($event->users()->wherePivot('volunteer', true)->get()) }} Volunteers
                                attending
                            </h2>
                        </div>
                    </div>
                    <div class="flex-1 text-right">
                        <button class="bg-green-300 hover:bg-green-400 text-green-800 font-bold py-2 px-4 rounded-full">
                            <i class="far fa-circle-check mr-2"></i>
                            <span>Volunteering</span>
                        </button>
                        <button class="bg-red-300 hover:bg-red-400 text-red-800 font-bold py-2 px-4 rounded-full">
                            <i class="far fa-circle-xmark mr-2"></i>
                            <span>Not Attending</span>
                        </button>
                        <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full">
                            <i class="far fa-circle-question mr-2"></i>
                            <span>RSVP</span>
                        </button>
                    </div>
                </div>

                <p>{{ $event->users()->wherePivot('volunteer', true)->implode('name', ', ') }}</p>
                <h2 class="text-xl">Skills Available:</h2>
                <p>{{ $event->skills()->pluck('name')->implode(', ') }}</p>
            </div>

            <div class="bg-white sm:rounded-xl shadow-md p-4 mb-4">

                <div class="flex items-center">
                    <div class="flex-1 text-left">
                        <div class="flex items-center">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $event->items->count() }} Booked in items:
                            </h2>
                        </div>
                    </div>
                    <div class="flex-1 text-right">
                        <button class="bg-green-300 hover:bg-green-400 text-green-800 font-bold py-2 px-4 rounded-full">
                            <i class="far fa-plus mr-2"></i>
                            <span>Add Item</span>
                        </button>
                    </div>
                </div>

                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Owner
                                    </th>

                                    <th scope="col"
                                        class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Details
                                    </th>

                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Issue Description
                                    </th>

                                    <th scope="col" class="relative py-3.5 px-0">
                                        <span class="sr-only">Manage</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">

                                @foreach ($event->items as $item)
                                    <tr>
                                        <td class="px-2 py-2 text-sm font-medium whitespace-nowrap">
                                            <div>
                                                @if ($item->user)
                                                    <h2 class="font-medium text-gray-800 dark:text-white ">
                                                        {{ $item->user->name }}
                                                    </h2>
                                                @else
                                                    <h2
                                                        class="text-sm italic font-normal text-gray-600 dark:text-gray-400">
                                                        Anonymous
                                                    </h2>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 text-sm font-medium whitespace-nowrap">

                                            <div>
                                                <p class="text-gray-500 dark:text-gray-400 ">
                                                    {{ $item->category->name }}:
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-gray-700 dark:text-gray-200 ">{{ $item->description }}
                                                </p>
                                            </div>
                                            @switch($item->powered)
                                                @case('no')
                                                    <div
                                                        class="text-sm bg-gray-200 text-gray-800 py-1 px-2 text-center rounded-full mt-1">
                                                        <i class="fas fa-plug-circle-xmark"></i>
                                                        <span>Unpowered</span>
                                                    </div>
                                                @break

                                                @case('batteries')
                                                    <div
                                                        class="text-sm bg-green-200 text-green-800 py-1 px-2 text-center rounded-full mt-1">
                                                        <i class="fas fa-battery-half"></i>
                                                        <span>Battery Powered</span>
                                                    </div>
                                                @break

                                                @case('mains')
                                                    <div
                                                        class="text-sm bg-red-200 text-red-800 py-1 px-1 text-center rounded-full mt-1">
                                                        <i class="fas fa-plug-circle-bolt"></i>
                                                        <span>Mains Powered</span>
                                                    </div>
                                                @break

                                                @case('other')
                                                    <div
                                                        class="text-sm bg-yellow-200 text-yellow-800 py-1 px-1 text-center rounded-full mt-1">
                                                        <i class="fas fa-plug-circle-exclamation"></i>
                                                        <span>Other</span>
                                                    </div>
                                                @break

                                                @default
                                                    <div
                                                        class="text-sm bg-blue-200 text-blue-800 py-1 px-1 text-center rounded-full mt-1">
                                                        <i class="fas fa-circle-question"></i>
                                                        <span>Unknown</span>
                                                    </div>
                                            @endswitch

                                            @switch($item->status)
                                                @case('broken')
                                                    <div
                                                        class="text-sm bg-gray-200 text-gray-800 py-1 px-2 text-center rounded-full mt-1">
                                                        <i class="fas fa-plug-circle-xmark"></i>
                                                        <span>Broken</span>
                                                    </div>
                                                @break

                                                @case('fixed')
                                                    <div
                                                        class="text-sm bg-green-200 text-green-800 py-1 px-2 text-center rounded-full mt-1">
                                                        <i class="fas fa-battery-half"></i>
                                                        <span>Battery Powered</span>
                                                    </div>
                                                @break

                                                @case('mains')
                                                    <div
                                                        class="text-sm bg-red-200 text-red-800 py-1 px-1 text-center rounded-full mt-1">
                                                        <i class="fas fa-plug-circle-bolt"></i>
                                                        <span>Mains Powered</span>
                                                    </div>
                                                @break

                                                @case('other')
                                                    <div
                                                        class="text-sm bg-yellow-200 text-yellow-800 py-1 px-1 text-center rounded-full mt-1">
                                                        <i class="fas fa-plug-circle-exclamation"></i>
                                                        <span>Other</span>
                                                    </div>
                                                @break

                                                @default
                                                    <div
                                                        class="text-sm bg-blue-200 text-blue-800 py-1 px-1 text-center rounded-full mt-1">
                                                        <i class="fas fa-circle-question"></i>
                                                        <span>Unknown</span>
                                                    </div>
                                            @endswitch
                                        </td>
                                        <td class="px-2 py-2 text-sm">
                                            <div>
                                                <p class="text-gray-700 dark:text-gray-200">{{ $item->issue }}</p>
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 text-sm whitespace-nowrap text-right">
                                            <div x-data="{ isOpen: false }" class="relative inline-block">
                                                <!-- Dropdown toggle button -->
                                                <button @click="isOpen = !isOpen"
                                                    class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div x-show="isOpen" @click.away="isOpen = false"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="opacity-0 scale-90"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-100"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-90"
                                                    class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800">
                                                    <a href="{{ route('item',["id"=>$item->id]) }}"
                                                        class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                                        View Details</a>
                                                    <a href="#"
                                                        class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                                        Remove from event</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
