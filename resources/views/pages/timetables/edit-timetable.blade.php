<div>
    <x-layouts.app.breadcrumb :links="$this->breadcrumb" />
    <x-ui.page-title>{{ __('Kemaskini Jadual') }}</x-ui.page-title>

    <x-ui.section class="p-6 max-w-4xl">
        <form wire:submit="update">
            {{ $this->form }}

            <div class="pt-6">
                <x-filament::button type="submit">
                    {{ __('Kemaskini') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </x-ui.section>
</div>
