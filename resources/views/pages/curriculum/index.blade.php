<?php

use Livewire\Volt\Component;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Curricula;
use App\Models\Semester;
use App\Models\Week;

new class extends Component {
    public Semester $semester;

    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
    }

    public function with(): array
    {
        $curriculum = Curricula::query()
            ->with(['userCurriculum' => fn(Builder $query) => $query->where('user_id', auth()->user()->id)->where('semester_id', $this->semester->id)])
            ->orderBy('position', 'ASC')
            ->get();

        return [
            'curriculum' => $curriculum,
            'weeks' => Week::all(),
            'headerCount' => 0,
        ];
    }
};

?>


<div>
    @php
        $breadcrumb = [
            [
                'name' => __('Halaman Utama'),
                'href' => route('dashboard', $semester),
                'icon' => 'heroicon-s-home',
            ],
            [
                'name' => __('Kalendar Aktiviti'),
                'href' => '',
                'icon' => '',
            ],
        ];
    @endphp
    <x-layouts.app.breadcrumb :links="$breadcrumb" />

    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Kalendar Aktiviti') }}</h2>
    <div class="p-6 mt-5 bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="flex justify-between items-center text-center">
            <div></div>
            <x-ui.link-primary href="{{ route('curriculum.create', $semester) }}">{{ __('Tambah') }}</x-ui.link-primary>
        </div>

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
                                                    <a href="{{ route('curriculum.edit', ['semester' => $semester, 'curricula' => $activity]) }}"
                                                        class="ml-2 text-xs uppercase font-semibold {{ $activity->accomplished_at != null ? ' bg-yellow-100 px-1 py-1 rounded border border-yellow-200 text-orange-600' : 'text-primary-500' }}">
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
