<?php

namespace App\Livewire\Teacher\Services;

use App\Models\Semester;
use App\Models\Teacher;
use App\Services\FileService;

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
        if($this->teacher == null){
            return;
        }
        
        if(isset($data['image'])){
            (new FileService($this->teacher))->storeToCollection($data['image'], Teacher::MEDIA_AVATAR, true);
        }

        $data['type'] = $data['position'];
        unset($data['image']);
        $this->teacher->update($data);
    }

    public function deleteAvatar()
    {
        (new FileService($this->teacher))->deleteAllFromCollection(Teacher::MEDIA_AVATAR);
    }
}