<?php

namespace App\Livewire\Curricula\Views\Pages;

use App\Livewire\Curricula\Services\CurriculaService;
use App\Models\Curricula;
use App\Models\Semester;
use App\Models\Week;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateCurricula extends Component implements HasForms {
    use InteractsWithForms;
    public Semester $semester;
    public ?array $data = [];

    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
    }

    public function render(): View
    {
        

        return view('pages.curriculum.create-curricula', [
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
                'name' => __('Kalendar Aktiviti'),
                'href' => route('curriculum.index', $this->semester),
                'icon' => 'heroicon-s-calendar-days',
            ],
            [
                'name' => __('Tambah'),
                'href' => '',
                'icon' => '',
            ],
        ];
    }


    public function create(): void
    {
        $data = $this->form->getState();
        (new CurriculaService($this->semester))->create($data);
        $this->dispatch('toast', message: 'Data berjaya dikemaskini.', data: ['position' => 'top-right', 'type' => 'success']);
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('curricula_id')
                    ->label('Kokurikulum')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(Curricula::all()->pluck('name', 'id')),
                Group::make()->schema([
                    Grid::make(3)->schema([
                        DatePicker::make('plan_started_at')
                            ->label('Tarikh Mula Plan')
                            ->required()
                            ->native(false)
                            ->closeOnDateSelection()
                            ->suffixIcon('heroicon-s-calendar-days'),
                        DatePicker::make('plan_ended_at')
                            ->label('Tarikh Akhir Plan')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->suffixIcon('heroicon-s-calendar-days'),
                        Select::make('week')
                            ->label('Minggu')
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->options(Week::all()->pluck('name', 'id')),
                    ]),
                ]),
            ])
            ->statePath('data')
            ->model(UserCurriculum::class);
    }
}