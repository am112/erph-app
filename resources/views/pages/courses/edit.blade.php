<?php

use Livewire\Volt\Component;
use App\Models\AnnualCoursePlan;
use App\Models\Course;
use App\Models\Month;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use App\Http\Services\CourseService;

new class extends Component implements HasForms {
    use InteractsWithForms;
    public Semester $semester;
    public AnnualCoursePlan $record;

    public ?array $data = [];

    public function mount(Semester $semester, AnnualCoursePlan $annualCourse): void
    {
        $this->semester = $semester;
        $this->record = $annualCourse;
        $this->record->load('standardContents', 'standardLessons');
        $data = $this->record->attributesToArray();
        $data['standard_contents_id'] = $this->record->standardContents->pluck('id')->toArray();
        $data['standard_lessons_id'] = $this->record->standardLessons->pluck('id')->toArray();
        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Select::make('month_id')
                            ->label('Bulan')
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->options(Month::all()->pluck('name', 'id')),
                    ]),
                ]),
                Forms\Components\Select::make('pillar_id')
                    ->label('Tunjang')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(
                        Course::select('id', DB::raw("concat(code, ' - ', name) as codename"))
                            ->tunjang()
                            ->get()
                            ->pluck('codename', 'id'),
                    ),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Select::make('standard_contents_id')
                            ->label('Standard Kandungan')
                            ->required()
                            ->multiple()
                            ->native(false)
                            ->searchable()
                            ->options(
                                fn(Get $get): array => Course::query()
                                    // ->select('id', DB::raw("concat(code, ' - ', SUBSTRING(name, 1, 20)) as codename"))
                                    ->where('parent_id', $get('pillar_id'))
                                    ->whereNotNull('parent_id')
                                    ->get()
                                    ->pluck('code', 'id')
                                    ->toArray(),
                            ),

                        Forms\Components\Select::make('standard_lessons_id')
                            ->label('Standard Pembelajaran')
                            ->required()
                            ->multiple()
                            ->native(false)
                            ->searchable()
                            ->options(
                                fn(Get $get): array => Course::whereIn('parent_id', $get('standard_contents_id'))
                                    ->whereNotNull('parent_id')
                                    ->get()
                                    ->pluck('code', 'id')
                                    ->toArray(),
                            ),
                    ]),
                ]),
                Forms\Components\Textarea::make('description')
                    ->label('Catatan')
                    ->maxLength(255),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function edit(): void
    {
        $data = $this->form->getState();
        (new CourseService($this->semester))->update($data, $this->record);

        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
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
                'name' => __('Rancangan Pelajaran'),
                'href' => route('courses.index', $semester),
                'icon' => 'heroicon-m-academic-cap',
            ],
            [
                'name' => __('Kemaskini'),
                'href' => '',
                'icon' => '',
            ],
        ];
    @endphp
    <x-layouts.app.breadcrumb :links="$breadcrumb" />


    <div
        class="p-6 mt-6 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                {{ __('Kemaskini Rancangan Pelajaran Tahunan') }}</h2>
            <div class="">
                <livewire:modal-courses-list />
            </div>
        </div>

        <form wire:submit="edit">
            {{ $this->form }}

            <div class="mt-6">
                <x-ui.button-primary type="submit">
                    {{ __('Kemaskini') }}
                </x-ui.button-primary>
            </div>
        </form>

        <x-filament-actions::modals />
    </div>
</div>
