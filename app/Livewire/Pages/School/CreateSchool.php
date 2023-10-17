<?php

namespace App\Livewire\Pages\School;

use App\Models\School;
use App\Models\Semester;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CreateSchool extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public $record;
    public Semester $semester;

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
        if(auth()->user()->school != null){
            $this->record = Auth::user()->school;
            $this->form->fill($this->record->attributesToArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->label('SMPK No')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->maxLength(255),
            ])
            ->statePath('data')
            ->model($this->record ?? School::class);
    }

    public function create(): void
    {
        try{
            $data = $this->form->getState();
            if($this->record == null){
                $school = School::updateOrCreate(
                    ['code' => $data['code']],
                    $data,
                );
                Auth::user()->update([
                    'school_id' => $school->id,
                ]);
            }else{
                $this->record->update($data);
            }
            $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: [ 'position' => 'top-right', 'type' => 'success' ]);
        }catch(\Exception $e){
            $this->dispatch('toast', message: 'Kesilapan! Sila cuba lagi.', data: [ 'position' => 'top-right', 'type' => 'danger' ]);
        }
    }

    public function render(): View
    {
        return view('pages.school.create');
    }
}