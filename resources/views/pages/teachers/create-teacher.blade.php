<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Tambah PM/PPMS') }}</x-ui.page-title>
    <x-ui.section class="px-6 max-w-4xl">
        <form wire:submit="create">
            {{ $this->form }}

            <div class="py-6">
                <x-filament::button type="submit">
                    {{ __('Tambah') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </x-ui.section>
</div>
