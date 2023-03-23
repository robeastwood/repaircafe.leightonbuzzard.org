<a href="{{ route('item', ['id' => $item->id]) }}"
    class="block sm:m-4 mb-4 sm:rounded-xl bg-gray-50 hover:bg-gray-100 shadow-md">
    <div class="flex items-start gap-4 p-1 sm:p-6">
        <div>
            <h1 class="font-medium sm:text-lg">
                Item ID {{ $item->id }}: {{ $item->description }}
            </h1>

            <h2 class="font-medium text-gray-700">
                Category: {{ $item->category->name }}
            </h2>

            <h2 class="font-medium text-gray-700">
                Owner:
                @if ($item->user)
                    {{ $item->user->name }}
                @else
                    <span class="text-sm italic">
                        Unregistered User
                    </span>
                @endif
            </h2>

            <p class="text-sm text-gray-800 my-2">
                {!! nl2br(e($item->issue)) !!}
            </p>

            <div class="mt-2 sm:flex sm:items-center sm:gap-2">

                {{-- <p class="text-xs text-gray-500">
                    {{ $item->category->name }}
                </p>
                <span class="hidden sm:block" aria-hidden="true">&middot;</span> --}}

                <div class="flex items-center gap-1 text-gray-500">
                    <i class="far fa-comments"></i>
                    <p class="text-xs">0 notes</p>
                </div>

                <span class="hidden sm:block" aria-hidden="true">&middot;</span>

                <p class="hidden sm:block sm:text-xs sm:text-gray-500">
                    Added on {{ Carbon\Carbon::parse($item->created_at)->format('l jS \\of F, g:ia') }}
                </p>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        @switch($item->status)
            @case('broken')
                <strong
                    class="inline-flex items-center gap-1 rounded-tl-xl sm:rounded-br-xl bg-gray-600 py-1.5 px-3 text-white">
                    <i class="fas sm:text-2xl fa-heart-crack"></i>
                    <span class="font-medium text-xs sm:text-lg">Broken</span>
                </strong>
            @break

            @case('assessed')
                <strong
                    class="inline-flex items-center gap-1 rounded-tl-xl sm:rounded-br-xl bg-blue-600 py-1.5 px-3 text-white">
                    <i class="fas sm:text-2xl fa-magnifying-glass"></i>
                    <span class="font-medium text-xs sm:text-lg">Assessed</span>
                </strong>
            @break

            @case('fixed')
                <strong
                    class="inline-flex items-center gap-1 rounded-tl-xl sm:rounded-br-xl bg-green-600 py-1.5 px-3 text-white">
                    <i class="far sm:text-2xl fa-face-grin"></i>
                    <span class="font-medium text-xs sm:text-lg">Fixed</span>
                </strong>
            @break

            @case('awaitingparts')
                <strong
                    class="inline-flex items-center gap-1 rounded-tl-xl sm:rounded-br-xl bg-yellow-600 py-1.5 px-3 text-white">
                    <i class="far sm:text-2xl fa-hourglass"></i>
                    <span class="font-medium text-xs sm:text-lg">Awaiting Parts</span>
                </strong>
            @break

            @case('unfixable')
                <strong class="inline-flex items-center gap-1 rounded-tl-xl sm:rounded-br-xl bg-red-600 py-1.5 px-3 text-white">
                    <i class="fas sm:text-2xl fa-skull-crossbones"></i>
                    <span class="font-medium text-xs sm:text-lg">Unfixable</span>
                </strong>
            @break

            @default
                <strong
                    class="inline-flex items-center gap-1 rounded-tl-xl sm:rounded-br-xl bg-orange-600 py-1.5 px-3 text-white">
                    <i class="fas sm:text-2xl fa-circle-question"></i>
                    <span class="font-medium text-xs sm:text-lg">Unknown</span>
                </strong>
            @break
        @endswitch

    </div>
</a>

{{-- <a href="{{ route('item', ['id' => $item->id]) }}" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
    <span class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>

    <div class="sm:flex sm:justify-between sm:gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-900 sm:text-xl">
                Building a SaaS product as a software developer
            </h3>

            <p class="mt-1 text-xs font-medium text-gray-600">By John Doe</p>
        </div>

        <div class="hidden sm:block sm:shrink-0">
            <img alt="Paul Clapton"
                src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1180&q=80"
                class="h-16 w-16 rounded-lg object-cover shadow-sm" />
        </div>
    </div>

    <div class="mt-4">
        <div class="text-xs text-gray-500">Current Status</div>
        <p class="max-w-[40ch] text-sm text-gray-500">
            {!! nl2br(e($item->issue)) !!}
        </p>
    </div>

    <dl class="mt-6 flex gap-4 sm:gap-6">
        <div class="flex flex-col">
            <dd class="text-xs text-gray-500">Current Status</dd>
            <x-pill-status :status="$item->status" class="block" />
        </div>
    </dl>
</a> --}}

{{-- <div class="flex items-center">
        <div class="text-left">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    description
                </h2>
            </div>
        </div>
        <div class="text-right">
            button
        </div>
    </div>

    asdfasdfasdf

    <p>{{ $item->description }}</p>

    <div>
        @if ($item->user)
            <h2 class="font-medium text-gray-800">
                Owner: {{ $item->user->name }}
            </h2>
        @else
            <h2 class="text-sm italic font-normal text-gray-600">
                Unregistered User
            </h2>
        @endif
    </div>

    <div>
        <p class="text-gray-700 ">{{ $item->description }}
        </p>
    </div>

    <div>
        <p class="text-gray-500 my-2">
            Category: {{ $item->category->name }}
        </p>
    </div>

    <x-pill-powered :powered="$item->powered" class="block" />

    <x-pill-status :status="$item->status" class="block" />

    <div>
        <p class="text-gray-700">{!! nl2br(e($item->issue)) !!}</p>
    </div>

    <x-abutton href="{{ route('item', ['id' => $item->id]) }}">
        Open Details</x-abutton>

</div> --}}
