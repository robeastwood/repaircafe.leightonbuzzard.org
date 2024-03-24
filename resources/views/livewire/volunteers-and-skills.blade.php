<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ count($event->users()->wherePivot('volunteer', true)->get()) }} Volunteering
    </h2>
    <p><strong>Fixers:</strong> {{ $event->users()->wherePivot('fixer', true)->implode('name', ', ') }}</p>
    <p><strong>Helpers:</strong>
        {{ $event->users()->where('event_user.volunteer', true)->where(function ($query) {
                $query->where('event_user.fixer', 0)->orWhere('event_user.fixer', null);
            })->implode('name', ', ') }}
    </p>
    <h2 class="text-xl">Skills Available:</h2>
    <p>{{ $event->skills()->pluck('name')->implode(', ') }}</p>
</div>
