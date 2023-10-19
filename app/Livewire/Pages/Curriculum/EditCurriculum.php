<?php

namespace App\Livewire\Pages\Curriculum;

use App\Models\Semester;
use App\Models\UserCurriculum;
use App\Models\Week;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class EditCurriculum extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public UserCurriculum $record;
    public Semester $semester;

    public function mount(UserCurriculum $curricula, Semester $semester): void
    {
        $this->semester = $semester;
        $this->record = $curricula;
        $data = array_merge($this->record->attributesToArray(), ['accomplished' => ($curricula->accomplished_at == null ? false : true)]);
        $this->form->fill($data);
    }   

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('plan_started_at')
                ->label('Tarikh Mula Plan')
                ->required(true)                
                ->native(false)
                ->closeOnDateSelection()
                ->suffixIcon('heroicon-s-calendar-days'),
                Forms\Components\DatePicker::make('plan_ended_at')
                ->label('Tarikh Akhir Plan')
                ->required(false)
                ->native(false)
                ->closeOnDateSelection()
                ->suffixIcon('heroicon-s-calendar-days'),
                Forms\Components\Select::make('week')
                ->label('Minggu')
                ->required(true)
                ->native(false)
                ->searchable()
                ->options(Week::all()->pluck('name', 'id')),
                Forms\Components\Toggle::make('accomplished')
                ->label('Terlaksana'),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function edit(): void
    {
        $data = $this->form->getState();
        if($this->record->accomplished_at == null){
            $data['accomplished_at'] = $data['accomplished'] ==  true ? today() : null;            
        }else if($this->record->accomplished_at !== null && $data['accomplished'] == false){
            $data['accomplished_at'] = null; 
        }
        unset($data['accomplished']);

        $this->record->update($data);
        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: [ 'position' => 'top-right', 'type' => 'success' ]);

    }

    public function render(): View
    {
        return view('pages.curriculum.edit');
    }
}