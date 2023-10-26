<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />

    <div class="p-6 mt-6 bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="flex justify-between items-center text-center mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('PM / PPMS') }}</h2>
        </div>
        <div>
            {{ $this->table }}
        </div>
    </div>
</div>
