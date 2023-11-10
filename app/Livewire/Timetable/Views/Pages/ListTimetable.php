<?php

namespace App\Livewire\Timetable\Views\Pages;

use App\Models\Rph;
use App\Models\Semester;
use App\Models\Timetable;
use App\Models\Week;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ListTimetable extends Component
{
    public Semester $semester;
    public Rph $rph;
    public $media;

    public function mount(Semester $semester, Rph $rph): void
    {
        $rph->load('week');
        $this->semester = $semester;
        $this->rph = $rph;
    }
    public function render()
    {
        return view('pages.timetables.list-timetable');
    }

    #[Computed]
    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            route('rph.index', $this->semester) => __('RPH'),
            '' => __('Jadual'),
        ];
    }

    #[Computed]
    public function timetables(){
        $data = Timetable::query()
            ->with('field')
            ->where('rph_id', $this->rph->id)
            ->orderBy('date_at','asc')
            ->orderBy('start_time','asc')
            ->get();
        return $data;
    }
}
