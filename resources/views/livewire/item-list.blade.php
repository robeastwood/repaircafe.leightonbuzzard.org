<div>
    <div class="min-w-full py-2 align-middle">

        @foreach ($items as $item)
            @livewire('item-card', ['item' => $item, 'event' => $event], key($item->id))
        @endforeach

    </div>
</div>
