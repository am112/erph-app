<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <div
        class="p-6 mt-6 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                {{ __('Tambah PM/PPMS') }}
            </h2>
        </div>

        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-6">
                <x-ui.button-primary type="submit">
                    {{ __('Tambah') }}
                </x-ui.button-primary>
            </div>

        </form>
        <x-filament-actions::modals />
    </div>
</div>
