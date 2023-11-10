<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Ahli Jawatankuasa') }}</x-ui.page-title>
    <div>
        {{ $this->table }}
    </div>
</div>
