<?php

namespace App\Livewire\Teacher\Views\Pages;

use App\Livewire\Teacher\Services\TeacherService;
use App\Livewire\Teacher\Views\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateTeacher extends Component implements HasForms {
    use InteractsWithForms;

    public Semester $semester;
    public ?array $data = [];

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
    }

    public function render()
    {
        return view('pages.teachers.create-teacher', [
            'breadcrumb' => $this->breadcrumb(),
        ]);
    }

    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            route('profile.teachers.index', $this->semester) => __('PM / PPMS'),
            '' => __('Tambah'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(TeacherResource::getFormColumns(true))
            ->statePath('data')
            ->model($this->record ?? Teacher::class);
    }

    public function create(): void
    {
        (new TeacherService($this->semester, null))->create($this->form->getState());
        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
        $this->form->fill();
    }
};
