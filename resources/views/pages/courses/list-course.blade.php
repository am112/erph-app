<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Rancangan Pelajaran Tahunan') }}</x-ui.page-title>
    <div>
        <div>
            {{ $this->table }}
        </div>
        <div class="flex justify-end mt-4">
            <livewire:modal-courses-list lazy />
        </div>
    </div>
</div>
