<div>
    <x-layouts.app.breadcrumb :links="$this->breadcrumb" />
    <x-ui.page-title>{{ __('Kalendar Aktiviti') }}</x-ui.page-title>

    <x-ui.section>
        <div
            class="p-4 px-6 flex justify-between items-center text-center border-b border-gray-200 dark:border-gray-700">
            <div></div>
            <x-filament::button tag="a" href="{{ route('curriculum.create', $semester) }}">
                {{ __('Tambah') }}
            </x-filament::button>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
                <thead style="top: 0; position:stick; "
                    class="bg-gray-50 dark:bg-gray-800 text-sm font-semibold text-gray-700 dark:text-gray-300">
                    <tr>
                        <th style="position: sticky; left:0; " scope="col"
                            class="px-6 py-3 dark:text-gray-300 bg-gray-50 dark:bg-gray-800">
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
                                class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th style="position: sticky; left:0;" scope="row"
                                    class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap dark:text-gray-300 bg-gray-50 dark:bg-gray-800 ">
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
                                class="bg-gray-50 border-b dark:bg-white/5 dark:border-gray-700">
                                <th style="position:sticky; left:0;" scope="row"
                                    class="px-6 py-4 font-semibold text-gray-700 whitespace-nowrap dark:text-gray-300 bg-gray-50 dark:bg-gray-800 max-w-md">
                                    @php
                                        $headerCount += 1;
                                    @endphp
                                    <span class="max-w-md">{{ $headerCount }}.
                                        {{ $item['name'] }}</span>
                                </th>
                                @foreach ($this->weeks as $week)
                                    <th scope="col" class=" bg-gray-50 dark:bg-gray-800"></th>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.section>
</div>
