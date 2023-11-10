<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Kemaskini Kalendar Aktiviti') }}</x-ui.page-title>

    <x-ui.section class="max-w-4xl p-6">
        <form wire:submit="edit">
            {{ $this->form }}

            <div class="flex mt-6 gap-4">
                <x-filament::button type="submit">
                    {{ __('Kemaskini') }}
                </x-filament::button>
                {{ $this->deleteAction }}
            </div>

        </form>
        <x-filament-actions::modals />
    </x-ui.section>
</div>
