<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ count($event->users()->wherePivot('volunteer', true)->get()) }} Volunteers
        attending
    </h2>
    <p>{{ $event->users()->wherePivot('volunteer', true)->implode('name', ', ') }}</p>
    <h2 class="text-xl">Skills Available:</h2>
    <p>{{ $event->skills()->pluck('name')->implode(', ') }}</p>
</div>
