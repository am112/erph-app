<div>
    <x-layouts.app.breadcrumb :links="$this->breadcrumb" />

    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-5">{{ __('Kalendar Aktiviti') }}</h2>
    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="flex justify-between items-center text-center">
            <div></div>
            <x-filament::button tag="a" href="{{ route('curriculum.create', $semester) }}">
                {{ __('Tambah') }}
            </x-filament::button>
        </div>

        <div class="relative overflow-x-auto mt-8">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead style="top: 0; position:stick; "
                    class="bg-gray-50 dark:bg-gray-700 text-sm font-semibold text-gray-950 dark:text-white">
                    <tr>
                        <th style="position: sticky; left:0; " scope="col"
                            class="px-6 py-3 dark:text-white bg-gray-50 dark:bg-gray-700">
                            {{ __('Aktiviti Kokurikulum') }}
                        </th>
                        @foreach ($this->weeks as $week)
                            <th scope="col" class="px-20 py-3 w-48 text-center">
                                {{ $week->name }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->curriculum as $item)
                        @if ($item->is_subitem)
                            <tr style="position: relative;"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th style="position: sticky; left:0;" scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white bg-gray-50 dark:bg-gray-700 ">
                                    <span class=" pl-5">{{ $item['name'] }}</span>
                                </th>
                                @foreach ($this->weeks as $week)
                                    <td>
                                        <div class="flex items-center gap-1 mx-1 justify-center">
                                            @foreach ($item->userCurriculum as $activity)
                                                @if ($week->id === $activity->week)
                                                    <span>
                                                        <a
                                                            href="{{ route('curriculum.edit', ['semester' => $semester, 'curricula' => $activity]) }}">
                                                            <x-filament::badge
                                                                color="{{ $activity->accomplished_at != null ? 'warning' : 'info' }}">
                                                                {{ $activity->plan_started_at->format('d-M') }}
                                                            </x-filament::badge>
                                                        </a>
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>

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
                                @foreach ($this->weeks as $week)
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
