<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <h2 class=" text-xl font-bold text-gray-900 dark:text-white">{{ __('Tambah Kalendar Aktiviti') }}</h2>

    <div
        class="p-6 mt-5 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">

        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit">
                    {{ __('Simpan') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </div>
</div>
