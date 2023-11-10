<?php

namespace App\Livewire\School\Views\Pages;

use App\Livewire\School\Services\SchoolService;
use App\Models\School;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use App\Livewire\School\Views\Resources\SchoolResource;
use Livewire\Component;

class EditSchool extends Component implements HasForms {
    use InteractsWithForms;

    public Semester $semester;
    public School $record;
    public ?array $data = [];

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
        if (auth()->user()->school != null) {
            $this->record = Auth::user()->school;
        }else{
            $this->record = (new SchoolService)->update(['code' => Auth::user()->username, 'name' => Auth::user()->name], null);
        }
        $this->form->fill($this->record->attributesToArray());
    }

    public function render()
    {
        return view('pages.schools.edit-school', [
            'breadcrumb' => $this->breadcrumb(),
        ]);
    }

    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            '' => __('Tabika'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(SchoolResource::getFormColumns())
            ->statePath('data')
            ->model($this->record ?? School::class);
    }

    public function create(): void
    {
        try {
            (new SchoolService())->update($this->form->getState(), $this->record);
            $this->dispatch('toast', message: 'Data berjaya dikemaskini.', data: ['position' => 'top-right', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Kesilapan! Sila cuba lagi.', data: ['position' => 'top-right', 'type' => 'danger']);
        }
    }
}
