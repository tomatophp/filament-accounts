<span class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white">
    @if(is_array($getState()))
        {{ json_encode($getState(), JSON_PRETTY_PRINT) }}
    @else
        {{ $getState() }}
    @endif

</span>
