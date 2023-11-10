<div>
    <x-layouts.app.breadcrumb :links="$this->breadcrumb" />
    <x-ui.page-title>{{ __('Tambah Jadual') }}</x-ui.page-title>

    <x-ui.section class="p-6 max-w-4xl">
        <form wire:submit="create">
            {{ $this->form }}

            <div class="pt-6">
                <x-filament::button type="submit">
                    {{ __('Tambah') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </x-ui.section>
</div>
