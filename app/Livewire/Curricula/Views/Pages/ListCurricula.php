<?php

namespace App\Livewire\Curricula\Views\Pages;

use App\Models\Curricula;
use App\Models\Semester;
use App\Models\Week;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ListCurricula extends Component {
    public Semester $semester;

    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
    }

    public function render(): View
    {
        return view('pages.curriculum.list-curricula', [
            'headerCount' => 0,
        ]);
    }

    #[Computed]
    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            '' => __('Kalendar Aktiviti'),
        ];
    }

    #[Computed]
    public function curriculum(){
        return Curricula::query()
            ->with(['userCurriculum' => fn(Builder $query) => $query->createdBy()->semester($this->semester->id)])
            ->orderBy('position', 'ASC')
            ->get();
    }

    #[Computed]
    public function weeks(){
        return Week::all();
    }
}
