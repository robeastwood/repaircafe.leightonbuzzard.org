<!-- Show all items for an event -->
<div>
    @foreach ($items as $item)
    <div class="bg-white sm:rounded-xl shadow-md flex flex-wrap p-4 mb-4">
        <div class="basis-full sm:basis-1/2">
            <h1 class="font-semibold text-xl text-gray-800">ID: {{ $item->id }}</h1>
            Category: {{ $item->category->name }}  <br/>
            Description: {{ $item->description }}  <br/>
            Issue: {{ $item->issue }}  <br/>
            Customer: {{ $item->user?->name ?? 'No customer assigned' }}
        </div>
    </div>
    @endforeach
</div>