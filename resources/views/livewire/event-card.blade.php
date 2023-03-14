<div class="bg-white sm:rounded-xl shadow-md flex flex-wrap p-4 mb-4">
    <div class="basis-full sm:basis-1/2">
        <h1 class="font-semibold text-xl text-gray-800">
            {{ Carbon\Carbon::parse($event->starts_at)->format('l jS \\of F') }}
        </h1>
        <h2 class="font-semibold text-gray-800">
            {{ Carbon\Carbon::parse($event->starts_at)->format('g:i A') }}
            -
            {{ Carbon\Carbon::parse($event->ends_at)->format('g:i A') }}
        </h2>
        <h3 class="font-semibold text-gray-500 mb-2">
            {{ $event->venue->name }}
        </h3>

        @if ($event->users()->wherePivot('volunteer', true)->get()->contains(Auth::user()))
            <span class="text-sm bg-green-300 text-green-800 font-bold py-1 px-2 rounded">
                <i class="fas fa-wrench"></i>
                <span>Volunteering</span>
            </span>
        @elseif ($event->users->contains(Auth::user()))
            <span class="text-sm bg-green-300 text-green-800 font-bold py-1 px-2 rounded">
                <i class="fas fa-check"></i>
                <span>Attending</span>
            </span>
        @endif

    </div>
    <div class="basis-full sm:basis-1/2 pt-4 sm:pt-0">
        <div class="uppercase tracking-wide text-sm text-teal-500 font-semibold">
            Volunteers attending:
            <strong>{{ count($event->users()->wherePivot('volunteer', true)->get()) }}</strong>
        </div>
        <div class="text-xs">
            Skills available: {{ $event->skills()->pluck('name')->implode(', ') }}
        </div>
        <div class="mt-2 uppercase tracking-wide text-sm text-yellow-500 font-semibold">
            Guests attending:
            <strong>{{ count($event->users()->wherePivot('volunteer', null)->get()) }}</strong>
        </div>
        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
            Items booked in: <strong>{{ count($event->items) }}</strong>
        </div>
    </div>
    <div class="pt-4 mx-auto">
        @if (Auth::user())
            <a href="{{ route('event', $event->id) }}"
                class="bg-green-700 hover:bg-green-600 text-white py-2 px-4 rounded">Book in an item to repair
            </a>
        @else
            <a href="{{ route('register') }}"
                class="bg-green-700 hover:bg-green-600 text-white py-2 px-4 rounded">Register to attend
            </a>
        @endif
    </div>
</div>
