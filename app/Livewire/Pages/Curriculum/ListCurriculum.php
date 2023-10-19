<?php

namespace App\Livewire\Pages\Curriculum;

use App\Models\Curricula;
use App\Models\Semester;
use App\Models\Week;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class ListCurriculum extends Component
{
    public Semester $semester;
    public function mount(Semester $semester){
        $this->semester = $semester;
    }

    public function render()
    {
        return view('pages.curriculum.index', [
            'curriculum' => Curricula::query()
            ->with(['userCurriculum' => function(Builder $query){
                $query->where('user_id', auth()->user()->id)
                ->where('semester_id', $this->semester->id);
            }])
            ->orderBy('position', 'ASC')
            ->get(),
            'weeks' => Week::all(),
        ]);
    }
}
