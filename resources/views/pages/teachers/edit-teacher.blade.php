<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
        {{ __('Kemaskini PM/PPMS') }}</h2>
    <div
        class="p-6 mt-5 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">

        @if ($avatarExist != null)
            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                Gambar
            </span>
            <div class="relative w-32 h-32 mt-2">
                <img class="rounded-full border w-32 h-32" src="{{ $record->getFirstMedia()->getFullUrl() }}"
                    alt="Extra large avatar" />
                <x-heroicon-m-trash
                    class="absolute bottom-3 left-11 w-9 h-9 text-gray-200 cursor-pointer p-2 border rounded-full border-gray-600 hover:border-white bg-gray-700 opacity-80"
                    wire:click="deleteAvatar" />
            </div>
        @endif
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
