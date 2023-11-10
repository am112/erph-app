<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('PM/PPMS') }}</x-ui.page-title>
    <div>
        {{ $this->table }}
    </div>

</div>
