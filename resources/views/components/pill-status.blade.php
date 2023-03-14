@switch($status)
    @case('broken')
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-gray-200 text-gray-800 py-1 px-2 text-center rounded-full m-1']) }}">
            <i class="fas fa-heart-crack"></i>
            <span>Broken</span>
        </span>
    @break

    @case('assessed')
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-blue-200 text-blue-800 py-1 px-2 text-center rounded-full m-1']) }}">
            <i class="fas fa-magnifying-glass"></i>
            <span>Assessed</span>
        </span>
    @break

    @case('fixed')
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-green-200 text-green-800 py-1 px-2 text-center rounded-full m-1']) }}">
            <i class="far fa-face-grin"></i>
            <span>Fixed</span>
        </span>
    @break

    @case('awaitingparts')
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-yellow-200 text-yellow-800 py-1 px-2 text-center rounded-full m-1']) }}">
            <i class="far fa-hourglass"></i>
            <span>Awaiting Parts</span>
        </span>
    @break

    @case('unfixable')
        <span {{ $attributes->merge(['class' => 'text-sm bg-red-200 text-red-800 py-1 px-2 text-center rounded-full m-1']) }}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Unfixable</span>
        </span>
    @break

    @default
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-orange-200 text-orange-800 py-1 px-2 text-center rounded-full m-1']) }}">
            <i class="fas fa-circle-question"></i>
            <span>Unknown</span>
        </span>
    @break
@endswitch
