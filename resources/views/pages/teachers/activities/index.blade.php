<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Kegiatan Sosial') }}</x-ui.page-title>
    <div>
        {{ $this->table }}
    </div>
</div>
