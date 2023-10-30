<?php

namespace App\Livewire\Course\Views\Pages;

use App\Livewire\Course\Services\CourseService;
use App\Models\AnnualCoursePlan;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use App\Livewire\Course\Views\Resources\CourseResource;
use Livewire\Component;

class EditCourse extends Component implements HasForms {
    use InteractsWithForms;

    public Semester $semester;
    public AnnualCoursePlan $record;
    public ?array $data = [];

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

    public function render()
    {
        return view('pages.courses.edit-course', [
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
                'name' => __('Kemaskini'),
                'href' => '',
                'icon' => '',
            ],
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(CourseResource::getFormColumns())
            ->statePath('data')
            ->model($this->record);
    }

    public function edit(): void
    {
        (new CourseService($this->semester))->update($this->form->getState(), $this->record);
        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
    }
}