<?php

namespace App\Livewire\Pages\Kokurikulum;

use App\Models\Kokurikulum;
use App\Models\KokurikulumUser;
use App\Models\Semester;
use App\Models\Week;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CreateKokurikulum extends Component implements HasForms
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
                Forms\Components\Select::make('kokurikulum_id')
                    ->label('Kokurikulum')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(Kokurikulum::all()->pluck('name', 'id')),
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
            ->model(KokurikulumUser::class);
    }

    public function create(): void
    {
            $data = $this->form->getState();
            $data['user_id'] = auth()->user()->id;
            $data['semester_id'] = $this->semester->id;
            $record = KokurikulumUser::create($data);
            $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: [ 'position' => 'top-right', 'type' => 'success' ]);
            $this->form->fill();
    }

    public function render(): View
    {
        return view('pages.kokurikulum.create');
    }
}