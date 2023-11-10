<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Kemaskini Maklumat Tabika') }}</x-ui.page-title>

    <x-ui.section class="p-5 max-w-4xl">
        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit">
                    {{ __('Kemaskini') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </x-ui.section>
</div>
