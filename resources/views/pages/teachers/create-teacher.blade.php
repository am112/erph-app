<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
        {{ __('Tambah PM/PPMS') }}
    </h2>
    <div
        class="px-6 py-0 mt-5 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">

        <form wire:submit="create">
            {{ $this->form }}

            <div class="py-6">
                <x-filament::button type="submit">
                    {{ __('Tambah') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </div>
</div>
