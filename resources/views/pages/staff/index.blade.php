<div>
    <x-layouts.app.breadcrumb>
        <li class="inline-flex items-center">
            <a href="{{ route('semester.dashboard', $semester) }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-heroicon-s-home class="w-4 h-4 mr-2.5" />
                {{ __('Halaman Utama') }}
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400 mx-1" />
                <span
                    class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('PM / PPMS') }}</span>
            </div>
        </li>
    </x-layouts.app.breadcrumb>

    <div>
        List of PM/PPMS
    </div>
</div>
