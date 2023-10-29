<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <div>
        {{-- <div class="p-6 mt-6 bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 "> --}}
        <div class="flex justify-between items-center text-center mb-5">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Maklumat Kanak Kanak') }}</h2>
        </div>
        <div>
            {{ $this->table }}
        </div>
        <div class="flex justify-end mt-4">
            <livewire:modal-courses-list />
        </div>
    </div>
</div>
