<?php

namespace App\Livewire;

use App\Models\StudentStatistic;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class StudentForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('semester_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('month_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('male_four')
                    ->numeric(),
                Forms\Components\TextInput::make('female_four')
                    ->numeric(),
                Forms\Components\TextInput::make('male_five')
                    ->numeric(),
                Forms\Components\TextInput::make('female_five')
                    ->numeric(),
                Forms\Components\TextInput::make('male_six')
                    ->numeric(),
                Forms\Components\TextInput::make('female_six')
                    ->numeric(),
                Forms\Components\TextInput::make('melayu')
                    ->numeric(),
                Forms\Components\TextInput::make('cina')
                    ->numeric(),
                Forms\Components\TextInput::make('india')
                    ->numeric(),
                Forms\Components\TextInput::make('others')
                    ->numeric(),
            ])
            ->statePath('data')
            ->model(StudentStatistic::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = StudentStatistic::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.student-form');
    }
}