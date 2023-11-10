<div>
    <x-layouts.app.breadcrumb :links="$this->breadcrumb" />
    <x-ui.page-title>{{ __('Rancangan Pelajaran Harian') }}</x-ui.page-title>
    <div>
        {{ $this->table }}
    </div>

    <x-filament::modal id="show-pdf" width="7xl" :close-by-clicking-away="false">
        <x-slot name="heading">
            {{ __('Lihat Attachment') }}
        </x-slot>
        <embed src="{{ $media }}" type="" height="900px" />
    </x-filament::modal>
</div>
