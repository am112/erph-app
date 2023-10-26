<?php

namespace App\Livewire\Course\Views\Pages;

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
use Livewire\Component;

class CreateCourse extends Component implements HasForms {
    use InteractsWithForms;
    public Semester $semester;

    public ?array $data = [];
    public AnnualCoursePlan $record;

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
    }

    public function render()
    {
        return view('pages.courses.create-course', [
            'breadcrumb' => $this->breadcrumb(),
        ]);
    }

    public function breadcrumb() : array
    {
        return [
            [
                'name' => __('Halaman Utama'),
                'href' => route('dashboard', $this->semester),
                'icon' => 'heroicon-s-home',
            ],
            [
                'name' => __('Rancangan Pelajaran'),
                'href' => route('courses.index', $this->semester),
                'icon' => 'heroicon-m-academic-cap',
            ],
            [
                'name' => __('Tambah'),
                'href' => '',
                'icon' => '',
            ],
        ];
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
            ->model($this->record ?? AnnualCoursePlan::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        (new CourseService($this->semester))->create($data);

        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
        $this->form->fill();
    }
}