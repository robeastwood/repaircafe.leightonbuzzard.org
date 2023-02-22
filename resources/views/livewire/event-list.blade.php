<div>
    <h1 class="font-semibold text-3xl text-gray-800 mb-4">Upcoming events:</h1>

    @foreach ($futureEvents as $event)
        <div class="bg-white sm:rounded-xl shadow-md overflow-hidden flex flex-wrap p-4 mb-4">
            <div class="basis-full sm:basis-1/2">
                <h1 class="font-semibold text-xl text-gray-800">
                    ID:{{ $event->id }},
                    {{ Carbon\Carbon::parse($event->starts_at)->format('l jS \\of F') }}
                </h1>
                <h2 class="font-semibold text-gray-800">
                    {{ Carbon\Carbon::parse($event->starts_at)->format('g:i A') }}
                    -
                    {{ Carbon\Carbon::parse($event->ends_at)->format('g:i A') }}
                </h2>
                <h3 class="font-semibold text-gray-500">
                    {{ $event->venue->name }}
                </h3>

                <div>
                    Volunteering: @if ($event->users->contains(Auth::user()))
                        <button
                            class="mt-4 text-sm bg-green-300 hover:bg-green-400 text-green-800 font-bold py-1 px-2 rounded">
                            <i class="fas fa-check"></i>
                            <span>Yes</span>
                        </button>
                    @else
                        <button
                            class="mt-4 text-sm bg-red-300 hover:bg-red-400 text-red-800 font-bold py-1 px-2 rounded">
                            <i class="fas fa-times"></i>
                            <span>No</span>
                        </button>
                    @endif
                </div>
            </div>
            <div class="basis-full sm:basis-1/2 pt-4 sm:pt-0">
                <div class="uppercase tracking-wide text-sm text-teal-500 font-semibold">
                    Volunteers attending:
                    <strong>{{ count($event->users()->wherePivot('volunteer', true)->get()) }}</strong>
                </div>
                Skills available:
                {{ $event->skills()->pluck('name')->implode(', ') }}
                <div class="mt-2 uppercase tracking-wide text-sm text-yellow-500 font-semibold">
                    Guests attending:
                    <strong>{{ count($event->users()->wherePivot('volunteer', false)->get()) }}</strong>
                </div>
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
                    Items booked in: <strong>{{ count($event->items) }}</strong>
                </div>
                <a href="/events/{{ $event->id }}"
                    class="block mt-2 text-lg leading-tight font-medium text-black hover:underline">Book in an item to
                    repair at this event</a>
            </div>
        </div>
    @endforeach
</div>
