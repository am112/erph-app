<?php

namespace App\Livewire\Curricula\Views\Pages;

use App\Models\Curricula;
use App\Models\Semester;
use App\Models\Week;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ListCurricula extends Component {
    public Semester $semester;

    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
    }

    public function render(): View
    {
        $curriculum = Curricula::query()
        ->with(['userCurriculum' => fn(Builder $query) => $query->where('user_id', auth()->user()->id)->where('semester_id', $this->semester->id)])
        ->orderBy('position', 'ASC')
        ->get();

        return view('pages.curriculum.list-curricula', [
            'breadcrumb' => $this->breadcrumb(),
            'curriculum' => $curriculum,
            'weeks' => Week::all(),
            'headerCount' => 0,
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
                'name' => __('Kalendar Aktiviti'),
                'href' => '',
                'icon' => '',
            ],
        ];
    }
}