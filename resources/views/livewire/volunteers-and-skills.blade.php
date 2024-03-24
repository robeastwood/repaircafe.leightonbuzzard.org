<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ count($event->users()->wherePivot('volunteer', true)->get()) }} Volunteering
    </h2>
    <p><strong>Fixers:</strong> {{ $event->users()->wherePivot('fixer', true)->implode('name', ', ') }}</p>
    <p><strong>Helpers:</strong> {{ $event->users()->wherePivot('volunteer', true)->wherePivot('fixer', false)->implode('name', ', ') }}</p>
    <h2 class="text-xl">Skills Available:</h2>
    <p>{{ $event->skills()->pluck('name')->implode(', ') }}</p>
</div>
