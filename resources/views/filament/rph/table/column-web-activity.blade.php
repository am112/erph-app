<div class="text-sm">
    @if (isset($getRecord()->rph) && $getRecord()->rph->web_activity != null)
        <button class="px-3" wire:click="setMedia('{{ $getRecord()->rph->web_activity }}')">
            <x-filament::badge color="warning">
                Web Aktiviti
            </x-filament::badge>
        </button>
    @endif
</div>
