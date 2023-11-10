<div>
    <x-layouts.app.breadcrumb :links="$this->breadcrumb" />
    <x-ui.page-title>{{ __('Maklumat Kanak Kanak') }}</x-ui.page-title>
    <div>
        {{ $this->table }}
    </div>
</div>
