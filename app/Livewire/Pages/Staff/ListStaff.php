<?php

namespace App\Livewire\Pages\Staff;

use App\Models\Semester;
use Livewire\Component;

class ListStaff extends Component
{
    public Semester $semester;
    public function mount(Semester $semester){
        $this->semester = $semester;
    }

    public function render()
    {
        return view('pages.staff.index');
    }
}
