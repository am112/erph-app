<?php

namespace App\Livewire\Pages;

use App\Models\Semester;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Livewire\Component;
use Illuminate\Support\Str;

class Dashboard extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Semester $semester;
    
    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
    }

    public function render()
    {
        return view('pages.dashboard.index');
    }

    public function showToast(){
        $this->dispatch('toast', message: 'Nothing to update.', data: [ 'position' => 'top-right', 'type' => 'warning' ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                ->schema([
                    
                    Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Set $set) {                                                                    
                                        $set('slug', Str::slug($state));
                                    }),

                                TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),
                    ]),

                                MarkdownEditor::make('description')
                                    ->columnSpan('full'),
                ])
                // ->columnSpan(['lg' => 2]),
                
            ])
            ->columns(1)
            ->statePath('data');
    }
    
    public function create(): void
    {
        dd($this->form->getState());
    }
}
