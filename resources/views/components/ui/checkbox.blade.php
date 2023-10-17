@props([
    'label' => '',
])

@php $wireModel = $attributes->get('wire:model');@endphp

<div class="flex items-start">
    <div class="flex items-center h-5">
        <input {{ $attributes }} type="checkbox"
            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $attributes->get('id') }}" class="text-gray-500 dark:text-gray-300">{{ $label }}</label>
    </div>
</div>
