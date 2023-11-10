<?php

namespace App\Livewire\Course\Views\Pages;

use App\Livewire\Course\Services\CourseService;
use App\Models\AnnualCoursePlan;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use App\Livewire\Course\Views\Resources\CourseResource;
use Illuminate\View\View;
use Livewire\Component;

class CreateCourse extends Component implements HasForms {
    use InteractsWithForms;

    public Semester $semester;
    public ?array $data = [];

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
    }

    public function render(): View
    {
        return view('pages.courses.create-course', [
            'breadcrumb' => $this->breadcrumb(),
        ]);
    }

    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            route('courses.index', $this->semester) => __('Rancangan Pelajaran'),
            '' => __('Tambah'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(CourseResource::getFormColumns())
            ->statePath('data')
            ->model(AnnualCoursePlan::class);
    }

    public function create(): void
    {
        (new CourseService($this->semester))->create($this->form->getState());

        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
        $this->form->fill();
    }
}
