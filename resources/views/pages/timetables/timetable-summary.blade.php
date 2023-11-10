<div>
    <x-layouts.app.breadcrumb :links="$this->breadcrumb" />
    <x-ui.page-title>
        <div class="flex items-center justify-between">
            <span>{{ $rph->week->name }}</span>
            <span>Tarikh: {{ $date_at->format('d/m/Y') }}</span>
            <span>Hari: {{ $date_at->translatedFormat('l') }}</span>
        </div>
    </x-ui.page-title>
    <div>
        {{ $this->table }}
    </div>

    <div
        class="px-6 py-6 mt-5 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">

        <form wire:submit="update">
            {{ $this->form }}

            <div class="pt-6">
                <x-filament::button type="submit">
                    {{ __('Kemaskini') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </div>
</div>
