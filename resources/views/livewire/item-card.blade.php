<a href="{{ route('item', ['id' => $item->id]) }}"
    class="block sm:m-4 mb-4 sm:rounded-xl bg-gray-50 hover:bg-gray-100 shadow-md">
    <div class="flex items-start gap-4 p-3 sm:p-6">
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
                    <p class="text-xs">{{ $item->notes()->count() }} notes</p>
                </div>

                <span class="hidden sm:block" aria-hidden="true">&middot;</span>

                <p class="hidden sm:block sm:text-xs sm:text-gray-500">
                    Added on {{ Carbon\Carbon::parse($item->created_at)->format('l jS \\of F, g:ia') }}
                </p>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <strong
            class="inline-flex items-center gap-1 rounded-tl-xl sm:rounded-br-xl py-1.5 px-3 {{ \App\Models\Item::statusOptions()[$item->status]['colour'] }}">
            <i class="{{ \App\Models\Item::statusOptions()[$item->status]['icon'] }} sm:text-2xl"></i>
            <span
                class="font-medium text-xs sm:text-lg">{{ \App\Models\Item::statusOptions()[$item->status]['display'] }}</span>
        </strong>
    </div>
</a>
