<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Tambah Kalendar Aktiviti') }}</x-ui.page-title>

    <x-ui.section class="max-w-4xl p-6">
        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit">
                    {{ __('Simpan') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </x-ui.section>
</div>
