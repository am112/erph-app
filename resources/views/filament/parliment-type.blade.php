<div class="fi-ta-text-item inline-flex items-center gap-1.5 text-sm text-gray-950 dark:text-white  " style="">
    <div>
        @if ($getRecord()->tag == 'negeri' || $getRecord()->tag == 'parliment')
            -
        @else
            {{ $getRecord()->ancestor?->name }}
        @endif
    </div>
</div>
