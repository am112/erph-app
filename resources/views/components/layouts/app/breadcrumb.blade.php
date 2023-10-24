@props([
    'links' => [],
])

<div>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            @foreach ($links as $item)
                <li class="inline-flex items-center">
                    @if ($loop->index > 0)
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400 mx-1" />
                    @endif
                    @if ($item['href'] !== '')
                        <a href="{{ $item['href'] }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            @if ($item['icon'] != '')
                                @svg($item['icon'], ['class' => 'w-4 h-4 mr-2.5'])
                            @endif
                            {{ $item['name'] }}
                        </a>
                    @else
                        <span
                            class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $item['name'] }}</span>
                    @endif
                </li>
            @endforeach
            {{ $slot }}
        </ol>
    </nav>
    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
</div>
