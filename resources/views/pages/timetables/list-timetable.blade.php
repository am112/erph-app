<div>
    <x-layouts.app.breadcrumb :links="$this->breadcrumb" />
    <x-ui.page-title>{{ __('Jadual') }}</x-ui.page-title>

    <x-ui.section>
        <div
            class="p-4 px-6 flex justify-between items-center text-center dark:border-gray-700 border-b border-gray-200">
            <div></div>
            <x-filament::button
                href="{{ route('rph.timetable.create', ['semester' => $semester->id, 'rph' => $rph->id]) }}"
                tag="a">
                Tambah
            </x-filament::button>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-sm font-semibold text-gray-900 bg-gray-50 dark:bg-white/5 dark:text-gray-400 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Tarikh
                        </th>
                        <th scope="col" colspan="10" class="px-6 py-3 text-center">
                            Masa & Subjek
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->timetables->pluck('date_at')->unique() as $date)
                        <tr
                            class="bg-white @if (!$loop->last) border-b @endif dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap dark:text-gray-400">
                                <a
                                    href="{{ route('rph.timetable.summaries', ['semester' => $semester, 'rph' => $rph, 'date_at' => $date]) }}">{{ $date }}</a>
                            </th>
                            @foreach ($this->timetables->where('date_at', $date) as $column)
                                <td class="px-6 py-4">
                                    <a class=" text-gray-900 dark:text-gray-400"
                                        href="{{ route('rph.timetable.edit', ['semester' => $semester, 'rph' => $rph, 'timetable' => $column]) }}">
                                        <span class="font-semibold hover:text-primary-500">
                                            {{ $column->start_time }}
                                            -
                                            {{ $column->end_time }}
                                        </span>
                                        <div class="flex gap-2 items-center">
                                            <span class="">
                                                {{ $column->field->name }}
                                            </span>
                                            @if ($column->language_id == 5)
                                                <x-filament::badge color="warning">
                                                    BM
                                                </x-filament::badge>
                                            @endif
                                        </div>
                                    </a>
                                </td>
                            @endforeach

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-sm">
                                {{ __('filament-tables::table.empty.heading') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.section>
</div>
