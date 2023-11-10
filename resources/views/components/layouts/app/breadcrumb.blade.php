@props([
    'links' => [],
])

<div>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            @foreach ($links as $link => $name)
                <li class="inline-flex items-center">
                    @if ($loop->index > 0)
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400 mx-1" />
                    @endif
                    @if ($link !== '')
                        <a href="{{ $link }}"
                            class="ml-1 text-sm font-semibold text-gray-500 md:ml-2 dark:text-gray-500 hover:text-primary-500 dark:hover:text-primary-500">

                            {{ $name }}
                        </a>
                    @else
                        <span
                            class="ml-1 text-sm font-semibold text-gray-500 md:ml-2 dark:text-gray-500">{{ $name }}</span>
                    @endif
                </li>
            @endforeach
            {{ $slot }}
        </ol>
    </nav>
    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
</div>
