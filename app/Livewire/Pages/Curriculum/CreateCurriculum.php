<?php

namespace App\Livewire\Pages\Curriculum;

use App\Models\Curricula;
use App\Models\Semester;
use App\Models\UserCurriculum;
use App\Models\Week;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CreateCurriculum extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Semester $semester;

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('curricula_id')
                    ->label('Kokurikulum')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(Curricula::all()->pluck('name', 'id')),
                Forms\Components\DatePicker::make('plan_started_at')
                ->label('Tarikh Mula Plan')
                ->required()             
                ->native(false)
                ->closeOnDateSelection()
                ->suffixIcon('heroicon-s-calendar-days'),
                Forms\Components\DatePicker::make('plan_ended_at')
                ->label('Tarikh Akhir Plan')
                ->native(false)
                ->closeOnDateSelection()
                ->suffixIcon('heroicon-s-calendar-days'),
                Forms\Components\Select::make('week')
                ->label('Minggu')
                ->required()
                ->native(false)
                ->searchable()
                ->options(Week::all()->pluck('name', 'id')),
            ])
            ->statePath('data')
            ->model(UserCurriculum::class);
    }

    public function create(): void
    {
            $data = $this->form->getState();
            $data['user_id'] = auth()->user()->id;
            $data['semester_id'] = $this->semester->id;
            UserCurriculum::create($data);
            $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: [ 'position' => 'top-right', 'type' => 'success' ]);
            $this->form->fill();
    }

    public function render(): View
    {
        return view('pages.curriculum.create');
    }
}