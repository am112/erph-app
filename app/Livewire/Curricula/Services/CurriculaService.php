<?php

namespace App\Livewire\Curricula\Services;

use App\Models\Semester;
use App\Models\UserCurriculum;

class CurriculaService{

    public function __construct(public readonly Semester $semester)
    {
        
    }

    public function create(array $data): void
    {
        $data['user_id'] = auth()->id();
        $data['semester_id'] = $this->semester->id;
        UserCurriculum::create($data);
    }

    public function update(array $data, UserCurriculum $record): void
    {
        if($record->accomplished_at == null){
            $data['accomplished_at'] = $data['accomplished'] ==  true ? today() : null;            
        }else if($record->accomplished_at !== null && $data['accomplished'] == false){
            $data['accomplished_at'] = null; 
        }
        unset($data['accomplished']);
        $record->update($data);
    }

}