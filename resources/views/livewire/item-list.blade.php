<div>
    <div class="flex items-center">
        <div class="flex-1 text-left">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $items->count() }} Booked in items:
                </h2>
            </div>
        </div>
        <div class="flex-1 text-right">
            @livewire('create-item', ['event' => $event])
        </div>
    </div>

    <div class="inline-block min-w-full py-2 align-middle">
        <div class="border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500">
                            Owner
                        </th>

                        <th scope="col"
                            class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                            Details
                        </th>

                        <th scope="col"
                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                            Issue Description
                        </th>
{{-- 
                        <th scope="col" class="relative py-3.5 px-0">
                            <span class="sr-only">Manage</span>
                        </th> --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">

                    @foreach ($items as $item)
                        <tr wire:key="item-row-{{ $item->id }}">
                            <td class="px-2 py-2 text-sm font-medium whitespace-nowrap">
                                <div>
                                    @if ($item->user)
                                        <h2 class="font-medium text-gray-800">
                                            {{ $item->user->name }}
                                        </h2>
                                    @else
                                        <h2 class="text-sm italic font-normal text-gray-600">
                                            Anonymous
                                        </h2>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 py-2 text-sm font-medium whitespace-nowrap">

                                <div>
                                    <p class="text-gray-500 ">
                                        {{ $item->category->name }}:
                                    </p>
                                </div>

                                <div>
                                    <p class="text-gray-700 ">{{ $item->description }}
                                    </p>
                                </div>
                                @switch($item->powered)
                                    @case('no')
                                        <div class="text-sm bg-gray-200 text-gray-800 py-1 px-2 text-center rounded-full mt-1">
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
                                        <div class="text-sm bg-red-200 text-red-800 py-1 px-1 text-center rounded-full mt-1">
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
                                        <div class="text-sm bg-blue-200 text-blue-800 py-1 px-1 text-center rounded-full mt-1">
                                            <i class="fas fa-circle-question"></i>
                                            <span>Unknown</span>
                                        </div>
                                @endswitch

                                @switch($item->status)
                                    @case('broken')
                                        <div class="text-sm bg-gray-200 text-gray-800 py-1 px-2 text-center rounded-full mt-1">
                                            <i class="fas fa-heart-crack"></i>
                                            <span>Broken</span>
                                        </div>
                                    @break

                                    @case('assessed')
                                        <div class="text-sm bg-blue-200 text-blue-800 py-1 px-2 text-center rounded-full mt-1">
                                            <i class="fas fa-magnifying-glass"></i>
                                            <span>Assessed</span>
                                        </div>
                                    @break

                                    @case('fixed')
                                        <div
                                            class="text-sm bg-green-200 text-green-800 py-1 px-2 text-center rounded-full mt-1">
                                            <i class="far fa-face-grin"></i>
                                            <span>Fixed</span>
                                        </div>
                                    @break

                                    @case('awaitingparts')
                                        <div
                                            class="text-sm bg-yellow-200 text-yellow-800 py-1 px-2 text-center rounded-full mt-1">
                                            <i class="far fa-hourglass"></i>
                                            <span>Awaiting Parts</span>
                                        </div>
                                    @break

                                    @case('unfixable')
                                        <div class="text-sm bg-red-200 text-red-800 py-1 px-2 text-center rounded-full mt-1">
                                            <i class="fas fa-skull-crossbones"></i>
                                            <span>Unfixable</span>
                                        </div>
                                    @break
                                @endswitch
                            </td>
                            <td class="px-2 py-2 text-sm">
                                <div>
                                    <p class="text-gray-700">{!! nl2br(e($item->issue)) !!}</p>
                                </div>
                            </td>
                            {{-- <td class="px-2 py-2 text-sm whitespace-nowrap text-right">
                                <div x-data="{ isOpen: false }" class="relative inline-block">
                                    <!-- Dropdown toggle button -->
                                    <button @click="isOpen = !isOpen"
                                        class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
                                        class="absolute right-0 z-10 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl">
                                        <a href="{{ route('item', ['id' => $item->id]) }}"
                                            class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform hover:bg-gray-100-700">
                                            View Details</a>
                                        <a href="#"
                                            class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform hover:bg-gray-100-700">
                                            Remove from event</a>
                                    </div>
                                </div>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
