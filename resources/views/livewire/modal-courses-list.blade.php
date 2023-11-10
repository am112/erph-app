<?php

use Livewire\Volt\Component;

new class extends Component {
    public $courses = [];

    public function mount()
    {
        $this->courses = App\Models\Course::orderBy('code', 'ASC')->get();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <svg class="text-primary-500" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><style>.spinner_OSmW{transform-origin:center;animation:spinner_T6mA .75s step-end infinite}@keyframes spinner_T6mA{8.3%{transform:rotate(30deg)}16.6%{transform:rotate(60deg)}25%{transform:rotate(90deg)}33.3%{transform:rotate(120deg)}41.6%{transform:rotate(150deg)}50%{transform:rotate(180deg)}58.3%{transform:rotate(210deg)}66.6%{transform:rotate(240deg)}75%{transform:rotate(270deg)}83.3%{transform:rotate(300deg)}91.6%{transform:rotate(330deg)}100%{transform:rotate(360deg)}}</style><g class="spinner_OSmW"><rect x="11" y="1" width="2" height="5" opacity=".14"/><rect x="11" y="1" width="2" height="5" transform="rotate(30 12 12)" opacity=".29"/><rect x="11" y="1" width="2" height="5" transform="rotate(60 12 12)" opacity=".43"/><rect x="11" y="1" width="2" height="5" transform="rotate(90 12 12)" opacity=".57"/><rect x="11" y="1" width="2" height="5" transform="rotate(120 12 12)" opacity=".71"/><rect x="11" y="1" width="2" height="5" transform="rotate(150 12 12)" opacity=".86"/><rect x="11" y="1" width="2" height="5" transform="rotate(180 12 12)"/></g></svg>
        </div>
        HTML;
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
