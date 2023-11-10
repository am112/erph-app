<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <x-ui.page-title>{{ __('Kemaskini PM/PPMS') }}</x-ui.page-title>
    <x-ui.section class="p-6 max-w-4xl">
        @if ($avatarExist != null)
            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                Gambar
            </span>
            <div class="relative w-32 h-32 mt-2">
                <img class="rounded-full border w-32 h-32" src="{{ $record->avatar }}" alt="Extra large avatar" />
                <x-heroicon-m-trash
                    class="absolute bottom-3 left-11 w-9 h-9 text-gray-200 cursor-pointer p-2 border rounded-full border-gray-600 hover:border-white bg-gray-700 opacity-80"
                    wire:click="deleteAvatar" />
            </div>
        @endif
        <form wire:submit="edit">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit" wire:loading.attr="disabled">
                    {{ __('Kemaskini') }}
                </x-filament::button>
            </div>

        </form>
        <x-filament-actions::modals />
    </x-ui.section>
</div>
