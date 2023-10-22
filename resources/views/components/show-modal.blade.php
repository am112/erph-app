<x-filament::modal id="modal1">
    <x-slot name="trigger">
        <button x-on:click="$dispatch('open-modal', { id: 'modal1' })">Show modal</button>
    </x-slot>
    This is modal contents
</x-filament::modal>
