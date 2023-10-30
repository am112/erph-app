<?php

namespace App\Livewire\School\Services;

use App\Models\School;
use App\Models\User;

class SchoolService{

    public function __construct()
    {
        
    }

    public function update(array $data, School|null $record): void
    {       
        if ($record == null) {
            $school = School::updateOrCreate(['code' => $data['code']], $data);
            User::find(auth()->id())->update(['school_id' => $school->id,]);
        } else {
            $record->update($data);
        }
    }

}