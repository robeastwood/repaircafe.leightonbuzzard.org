@switch($powered)
    @case('no')
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-gray-200 text-gray-800 py-1 px-2 text-center rounded-full m-1']) }}">
            <i class="fas fa-plug-circle-xmark"></i>
            <span>Unpowered</span>
        </span>
    @break

    @case('batteries')
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-green-200 text-green-800 py-1 px-2 text-center rounded-full m-1']) }}">
            <i class="fas fa-battery-half"></i>
            <span>Battery Powered</span>
        </span>
    @break

    @case('mains')
        <span {{ $attributes->merge(['class' => 'text-sm bg-red-200 text-red-800 py-1 px-1 text-center rounded-full m-1']) }}">
            <i class="fas fa-plug-circle-bolt"></i>
            <span>Mains Powered</span>
        </span>
    @break

    @case('other')
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-yellow-200 text-yellow-800 py-1 px-1 text-center rounded-full m-1']) }}">
            <i class="fas fa-plug-circle-exclamation"></i>
            <span>Other</span>
        </span>
    @break

    @default
        <span
            {{ $attributes->merge(['class' => 'text-sm bg-blue-200 text-blue-800 py-1 px-1 text-center rounded-full m-1']) }}">
            <i class="fas fa-circle-question"></i>
            <span>Unknown</span>
        </span>
@endswitch
