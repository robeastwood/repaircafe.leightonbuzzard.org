<div>
    <h1 class="font-semibold text-3xl text-gray-800 mb-4">Upcoming events:</h1>

    @foreach ($futureEvents as $event)
        <livewire:event-card wire:key="event-card-{{ $event->id }}" :event="$event">
    @endforeach
    
</div>
