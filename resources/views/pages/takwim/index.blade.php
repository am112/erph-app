<?php

namespace App\Livewire\Pages\Staff;

use App\Models\Semester;
use Livewire\Component;

new class extends Component {
    public Semester $semester;
    public function mount(Semester $semester)
    {
        $this->semester = $semester;
    }
};

?>

<div>
    <x-layouts.app.breadcrumb>
        <li class="inline-flex items-center">
            <a href=""
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-heroicon-s-home class="w-4 h-4 mr-2.5" />
                {{ __('Halaman Utama') }}
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400 mx-1" />
                <span
                    class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('Takwim') }}</span>
            </div>
        </li>
    </x-layouts.app.breadcrumb>

    <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4"></div>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
    </div>
    <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4"></div>
    <div class="grid grid-cols-2 gap-4">
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
    </div>
</div>
