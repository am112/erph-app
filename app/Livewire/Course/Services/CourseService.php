<?php

namespace App\Livewire\Course\Services;

use App\Models\AnnualCoursePlan;
use App\Models\Semester;

class CourseService{

    public function __construct(public readonly Semester $semester)
    {
        
    }

    public function create(array $data): void
    {
        $model = AnnualCoursePlan::create([
            'user_id' => auth()->id(),
            'semester_id' => $this->semester->id,
            'month_id' => $data['month_id'],
            'pillar_id' => $data['pillar_id'],
            'description' => $data['description'],
        ]);
        $model->courses()->attach($data['standard_contents_id'], ['type' => 'standardContents']);
        $model->courses()->attach($data['standard_lessons_id'], ['type' => 'standardLessons']);
    }

    public function update(array $data, AnnualCoursePlan $record): void
    {
        $record->update([
            'month_id' => $data['month_id'],
            'pillar_id' => $data['pillar_id'],
            'description' => $data['description'],
        ]);
        $record->courses()->detach();
        $record->courses()->attach($data['standard_contents_id'], ['type' => 'standardContents']);
        $record->courses()->attach($data['standard_lessons_id'], ['type' => 'standardLessons']);
    }

}