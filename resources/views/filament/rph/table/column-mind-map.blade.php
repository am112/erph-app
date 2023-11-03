<div class="text-sm">
    @if (isset($getRecord()->rph) && $getRecord()->rph->mind_map != null)
        <button class="px-3" wire:click="setMedia('{{ $getRecord()->rph->mind_map }}')">
            <x-filament::badge color="success">
                Mind Map
            </x-filament::badge>
        </button>
    @endif
</div>
