<?php

use Livewire\Volt\Component;

new class extends Component {
    public $courses = [];

    public function mount()
    {
        $this->courses = App\Models\Course::orderBy('code', 'ASC')->get();
    }
}; ?>

<x-filament::modal id="modal1" slide-over sticky-header width="5xl">
    <x-slot name="trigger">
        <button x-on:click="$dispatch('open-modal', { id: 'modal1' })"
            class="text-primary-500 hover:underline text-sm">{{ __('Senarai Kod Standard') }}</button>
    </x-slot>
    <x-slot name="heading">
        {{ __('Senarai Kod Standard') }}
    </x-slot>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Kod Standard') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Nama') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4">
                            <x-filament::badge color="info">
                                {{ $item->code }}
                            </x-filament::badge>
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->name }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament::modal>
