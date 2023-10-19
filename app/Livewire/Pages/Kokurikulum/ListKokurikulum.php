<?php

namespace App\Livewire\Pages\Kokurikulum;

use App\Models\Kokurikulum;
use App\Models\Semester;
use App\Models\Week;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class ListKokurikulum extends Component
{
    public Semester $semester;
    public function mount(Semester $semester){
        $this->semester = $semester;
    }

    public function render()
    {
        return view('pages.kokurikulum.index', [
            'kokurikulums' => Kokurikulum::query()
            ->with(['activities' => function(Builder $query){
                $query->where('user_id', auth()->user()->id)
                ->where('semester_id', $this->semester->id);
            }])
            ->get(),
            'weeks' => Week::all(),
        ]);
    }
}
