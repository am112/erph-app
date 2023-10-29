<?php

namespace App\Livewire\Curricula\Views\Pages;

use App\Http\Services\CurriculaService;
use App\Models\Curricula;
use App\Models\Semester;
use App\Models\UserCurriculum;
use App\Models\Week;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EditCurricula extends Component implements HasForms {
    use InteractsWithForms;
    public Semester $semester;
    public UserCurriculum $record;

    public ?array $data = [];

    public function mount(UserCurriculum $curricula, Semester $semester): void
    {
        $this->semester = $semester;
        $this->record = $curricula;
        $data = array_merge($this->record->attributesToArray(), ['accomplished' => $curricula->accomplished_at == null ? false : true]);
        $this->form->fill($data);
    }

    public function render(): View
    {
        

        return view('pages.curriculum.edit-curricula', [
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
                'name' => __('Kemaskini'),
                'href' => '',
                'icon' => '',
            ],
        ];
    }


    public function edit(): void
    {
        $data = $this->form->getState();
        (new CurriculaService($this->semester))->update($data, $this->record);
        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
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
                Toggle::make('accomplished')->label('Terlaksana'),
            ])
            ->statePath('data')
            ->model(UserCurriculum::class);
    }
}