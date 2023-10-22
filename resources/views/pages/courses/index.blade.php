<div>
    <x-layouts.app.breadcrumb>
        <li class="inline-flex items-center">
            <a href="{{ route('semester.dashboard', $semester) }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-heroicon-s-home class="w-4 h-4 mr-2.5" />
                {{ __('Halaman Utama') }}
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400 mx-1" />
                <a href=""
                    class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ __('Rancangan Pelajaran Tahunan') }}</a>
            </div>
        </li>

    </x-layouts.app.breadcrumb>

    <div class="p-6 mt-6 bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="flex justify-between items-center text-center mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Rancangan Pelajaran Tahunan') }}</h2>
            <div class="flex gap-2">
                <x-ui.link-primary
                    href="{{ route('semester.courses.create', $semester) }}">{{ __('Kemaskini') }}</x-ui.link-primary>

            </div>
        </div>
        <div>
            {{ $this->table }}
        </div>
        <div class="flex justify-end mt-4">
            <livewire:modal-courses-list />
        </div>
    </div>
</div>
