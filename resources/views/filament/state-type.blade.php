<div class="fi-ta-text-item inline-flex items-center gap-1.5 text-sm text-gray-950 dark:text-white  " style="">
    <div>
        @if ($getRecord()->tag == 'dun')
            {{ $getRecord()->ancestor?->ancestor?->name }}
        @elseif($getRecord()->tag == 'parliment')
            {{ $getRecord()->ancestor?->name }}
        @else
            -
        @endif
    </div>
</div>
