<div class=" pl-4 text-sm">

    @php
        $total = $getRecord()->melayu + $getRecord()->cina + $getRecord()->india + $getRecord()->others;
    @endphp
    {{ $total }}
</div>
