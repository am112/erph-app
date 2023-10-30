<?php

namespace App\Livewire\School\Services;

use App\Models\School;
use App\Models\User;

class SchoolService{

    public function __construct()
    {
        
    }

    public function update(array $data, School|null $record): School
    {       
        if ($record == null) {
            $school = School::updateOrCreate(['code' => $data['code']], $data);
            User::find(auth()->id())->update(['school_id' => $school->id,]);
            return $school;
        } else {
            $record->update($data);
            return $record;
        }
    }

}