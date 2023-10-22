<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualCoursePlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function month(){
        return $this->belongsTo(Month::class, 'month_id');
    }

    public function pillar(){
        return $this->belongsTo(Course::class, 'pillar_id');
    }
    public function courses(){
        return $this->belongsToMany(Course::class, 'annual_course', 'annual_id', 'course_id');
    }

    public function standardContents(){
        return $this->courses()->wherePivot('type', 'standardContents');
    }

    public function standardLessons(){
        return $this->courses()->wherePivot('type', 'standardLessons');
    }
}
