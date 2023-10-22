<?php

namespace App\Livewire\Pages\Courses;

use App\Models\AnnualCoursePlan;
use App\Models\Course;
use App\Models\Month;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Forms;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;

class EditCourse extends Component implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];

    public $record;
    public Semester $semester;

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
                Forms\Components\Select::make('month_id')
                    ->label('Bulan')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(Month::all()->pluck('name', 'id')),
                Forms\Components\Select::make('pillar_id')
                    ->label('Tunjang')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(Course::select('id', DB::raw("concat(code, ' - ', name) as codename"))->tunjang()->get()->pluck('codename', 'id')),
                Forms\Components\Select::make('standard_contents_id')
                    ->label('Standard Kandungan')
                    ->required()
                    ->multiple()
                    ->native(false)
                    ->searchable()
                    ->options(fn(Get $get): array => Course::select('id', DB::raw("concat(code, ' - ', SUBSTRING(name, 1, 20)) as codename"))->where('parent_id', $get('pillar_id'))->whereNotNull('parent_id')->get()->pluck('codename', 'id')->toArray()),
                
                Forms\Components\Select::make('standard_lessons_id')
                    ->label('Standard Pembelajaran')
                    ->required()
                    ->multiple()
                    ->native(false)
                    ->searchable()
                    ->options(fn(Get $get): array => Course::whereIn('parent_id', $get('standard_contents_id'))->whereNotNull('parent_id')->get()->pluck('code', 'id')->toArray()),
                
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
        $this->record->update([
            'month_id' => $data['month_id'],
            'pillar_id' => $data['pillar_id'],
            'description' => $data['description'],
        ]);
        $this->record->courses()->detach();
        $this->record->courses()->attach($data['standard_contents_id'], ['type' => 'standardContents']);
        $this->record->courses()->attach($data['standard_lessons_id'], ['type' => 'standardLessons']);

        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: [ 'position' => 'top-right', 'type' => 'success' ]);
    }

    public function render()
    {
        return view('pages.courses.edit');
    }
}
