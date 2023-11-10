<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Kemaskini Rancangan Pelajaran Tahunan') }}</x-ui.page-title>
    <x-ui.section class="p-6 max-w-4xl">
        <div class="flex items-center justify-between">
            <div></div>
            <livewire:modal-courses-list lazy />
        </div>

        <form wire:submit="edit">
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
