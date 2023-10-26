<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
        {{ __('Kemaskini Rancangan Pelajaran Tahunan') }}</h2>
    <div
        class="p-6 mt-5 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="mb-0 flex justify-between items-center">
            <div></div>
            <div class="">
                <livewire:modal-courses-list />
            </div>
        </div>

        <form wire:submit="edit">
            {{ $this->form }}

            <div class="mt-6">
                <x-ui.button-primary type="submit">
                    {{ __('Kemaskini') }}
                </x-ui.button-primary>
            </div>
        </form>

        <x-filament-actions::modals />
    </div>
</div>
