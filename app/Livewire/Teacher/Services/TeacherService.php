<?php

namespace App\Livewire\Teacher\Services;

use App\Models\Semester;
use App\Models\Teacher;

class TeacherService{
    
    public function __construct(public Semester $semester, public ?Teacher $teacher)
    {
        
    }

    public function create(array $data): void
    {
        $data['user_id'] = auth()->id();
        $data['semester_id'] = $this->semester->id;
        $data['type'] = $data['position'];
        Teacher::create($data);
    }

    public function update(array $data): void
    {
        $data['type'] = $data['position'];
        
        if($data['image'] !== null){
            if ($this->teacher->getFirstMedia() != null) {
                $this->deleteAvatar();
            }

            $this->teacher->addMedia($data['image'])->toMediaCollection();            
        }
        unset($data['image']);
        $this->teacher->update($data);
    }

    public function deleteAvatar()
    {
        $this->teacher->getFirstMedia()->delete();
    }
}