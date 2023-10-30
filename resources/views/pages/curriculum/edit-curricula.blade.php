<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <h2 class=" text-xl font-bold text-gray-900 dark:text-white">{{ __('Kemaskini Kalendar Aktiviti') }}</h2>

    <div
        class="p-6 mt-5 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">

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
    </div>
</div>
