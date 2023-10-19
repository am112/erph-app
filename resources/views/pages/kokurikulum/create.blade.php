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
                <a href="{{ route('semester.kokurikulums.index', $semester) }}"
                    class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ __('Kalendar Aktiviti') }}</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400 mx-1" />
                <span
                    class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('Kemaskini') }}</span>
            </div>
        </li>
    </x-layouts.app.breadcrumb>

    <div
        class="p-6 mt-6 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __('Kemaskini Kalendar Aktiviti') }}</h2>

        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-6">
                <x-ui.button-primary type="submit">
                    {{ __('Kemaskini') }}
                </x-ui.button-primary>
            </div>

        </form>
        <x-filament-actions::modals />
    </div>
</div>
