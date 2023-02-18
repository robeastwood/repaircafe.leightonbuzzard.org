<div>
    <h1 class="font-semibold text-3xl text-gray-800 mb-4">Upcoming events:</h1>
    @foreach ($futureEvents as $event)
    <div
        class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-5xl p-4 mb-4"
    >
        <div class="md:flex">
            <div class="md:shrink-0">
                <h1 class="font-semibold text-xl text-gray-800">
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
                    Attending:
                    <button
                        class="mt-4 text-sm bg-green-300 hover:bg-green-400 text-green-800 font-bold py-1 px-2 rounded"
                    >
                        <i class="fas fa-check"></i>
                        <span>Yes</span>
                    </button>
                </div>
            </div>
            <div class="m-5">
                <div
                    class="uppercase tracking-wide text-sm text-teal-500 font-semibold"
                >
                    Volunteers attending: <strong>10</strong>
                </div>
                Skills available: {{ $skillList }}
                <div
                    class="uppercase tracking-wide text-sm text-yellow-500 font-semibold"
                >
                    Guests attending: <strong>10</strong>
                </div>
                <div
                    class="uppercase tracking-wide text-sm text-indigo-500 font-semibold"
                >
                    Items booked in: <strong>10</strong>
                </div>
                <a
                    href="#"
                    class="block mt-1 text-lg leading-tight font-medium text-black hover:underline"
                    >Book in an item to repair at this event</a
                >
                <!-- <p class="mt-2 text-slate-500">
                    lipsum
                </p> -->
            </div>
        </div>
    </div>
    @endforeach
</div>
