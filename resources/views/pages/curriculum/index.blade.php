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
                    class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('Kalendar Aktiviti') }}</span>
            </div>
        </li>
    </x-layouts.app.breadcrumb>

    <div class="p-6 mt-6 bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="flex justify-between items-center text-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Kalendar Aktiviti') }}</h2>
            <x-ui.link-primary
                href="{{ route('semester.curriculum.create', $semester) }}">{{ __('Kemaskini') }}</x-ui.link-primary>
        </div>

        @php
            $weekCount = 48;
            $headerCount = 0;

        @endphp

        <div class="relative overflow-x-auto mt-8">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead style="top: 0; position:stick; "
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th style="position: sticky; left:0; " scope="col"
                            class="px-6 py-3 dark:text-white bg-gray-50 dark:bg-gray-700">
                            {{ __('Aktiviti Kokurikulum') }}
                        </th>
                        @foreach ($weeks as $week)
                            <th scope="col" class="px-20 py-3 w-48 text-center">
                                {{ $week->name }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($curriculum as $item)
                        @if ($item->is_subitem)
                            <tr style="position: relative;"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th style="position: sticky; left:0;" scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white bg-gray-50 dark:bg-gray-700 ">
                                    <span class=" pl-5">{{ $item['name'] }}</span>
                                </th>
                                @foreach ($weeks as $week)
                                    <td class=" text-center">
                                        @foreach ($item->userCurriculum as $activity)
                                            @if ($week->id === $activity->week)
                                                <span>
                                                    <a href="{{ route('semester.curriculum.edit', ['semester' => $semester, 'curricula' => $activity]) }}"
                                                        class=" text-primary-500 ml-2 {{ $activity->accomplished_at != null ? ' bg-yellow-200 px-2 py-2 rounded' : '' }}">
                                                        {{ $activity->plan_started_at->format('d-M') }}
                                                    </a>
                                                </span>
                                            @endif
                                        @endforeach
                                    </td>
                                @endforeach
                            </tr>
                        @else
                            <tr style="position: relative;"
                                class="bg-gray-50 border-b dark:bg-gray-700 dark:border-gray-700">
                                <th style="position:sticky; left:0;" scope="row"
                                    class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap dark:text-white bg-gray-50 dark:bg-gray-700 max-w-md">
                                    @php
                                        $headerCount += 1;
                                    @endphp
                                    <span class="max-w-md">{{ $headerCount }}.
                                        {{ $item['name'] }}</span>
                                </th>
                                @foreach ($weeks as $week)
                                    <th scope="col" class=" bg-gray-50 dark:bg-gray-700"></th>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
