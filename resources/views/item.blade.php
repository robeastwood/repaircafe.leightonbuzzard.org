<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center">
            <div class="flex-1 text-left">
                <div class="flex items-center">
                    <i class="text-gray-800 text-lg md:text-3xl fas fa-heart-crack mr-4"></i>
                    <h2 class="font-semibold text-lg sm:text-2xl md:text-3xl text-gray-800 leading-tight">
                        Item ID {{ $item->id }}
                    </h2>
                </div>
            </div>
            <div class="flex-2 text-right">
                <h2 class="font-semibold text-base sm:text-lg md:text-xl text-gray-500 leading-tight">
                    Created: {{ Carbon\Carbon::parse($item->created_at)->format('l jS \\of F') }}
                </h2>
                <h2 class="font-semibold text-base sm:text-lg md:text-xl text-gray-500 leading-tight">
                    Last update: {{ Carbon\Carbon::parse($item->updated_at)->format('l jS \\of F') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white sm:rounded-xl shadow-md p-4 mb-4">

                <h1 class="text-2xl text-gray-800">{{ $item->description }}</h1>

                <p>Category: {{ $item->category->name }}</p>

                <div>

                    <div>
                        @if ($item->user)
                            <h2 class="font-medium text-gray-800">
                                Owner: {{ $item->user->name }}
                            </h2>
                        @else
                            <h2 class="text-sm italic font-normal text-gray-600">
                                Owner: Anonymous
                            </h2>
                        @endif
                    </div>

                    <p class="my-2">Powered: <x-pill-powered :powered="$item->powered" /></p>

                    <p class="my-2">Status: <x-pill-status :status="$item->status" /></p>

                </div>

                <div>
                    <h1 class="text-2xl text-gray-800">Issue Description:</h1>
                    <div class="text-gray-700">{!! nl2br(e($item->issue)) !!}</div>
                </div>

                <div>
                    <h1 class="text-2xl text-gray-800">Notes:</h1>
                    <div class="text-gray-700">{!! nl2br(e($item->notes)) !!}</div>
                </div>

                <div>
                    <h1 class="text-2xl text-gray-800">Registered at events:</h1>
                    <div class="text-gray-700">
                        @foreach ($item->events as $event)
                            <p>{{ Carbon\Carbon::parse($event->starts_at)->format('l jS \\of F, g:i a') }} @ {{ $event->venue->name }}</p>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
