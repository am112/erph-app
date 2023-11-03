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

class EditTeacher extends Component implements HasForms {

    use InteractsWithForms;
    
    public Semester $semester;
    public Teacher $record;

    public $avatarExist = false;
    public ?array $data;

    public function mount($semester, Teacher $teacher): void
    {
        $this->semester = $semester;
        $this->record = $teacher;
        $this->avatarExist = $this->record->getFirstMedia(Teacher::MEDIA_AVATAR) == null ? false : true;
        $this->form->fill($this->record->attributesToArray());
    }

    public function render()
    {
        return view('pages.teachers.edit-teacher', [
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
                'name' => __('Senarai PM / PPMS'),
                'href' => route('profile.teachers.index', $this->semester),
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
            ->schema(TeacherResource::getFormColumns($this->avatarExist))
            ->statePath('data')
            ->model($this->record);
    }

    public function deleteAvatar()
    {
        (new TeacherService($this->semester, $this->record))->deleteAvatar();
        $this->avatarExist = false;
    }

    public function edit(): void
    {
        (new TeacherService($this->semester, $this->record))->update($this->form->getState());
        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
    }
};