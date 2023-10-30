<div>
    <x-layouts.app.breadcrumb :links="$breadcrumb" />

    <div>
        <div class="flex justify-between items-center text-center mb-5">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Kegiatan Sosial') }}</h2>
        </div>
        <div>
            {{ $this->table }}
        </div>
    </div>
</div>
