<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCurriculum extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'user_curriculum';

    protected $casts = [
        'plan_started_at' => 'datetime:Y-m-d',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function semester(){
        return $this->belongsTo(Semester::class);
    }

    public function curriculum(){
        return $this->belongsTo(Curricula::class);
    }

    // =========================  scope ==============================

    public function scopeCreatedBy(Builder $query): void{
        $query->where('user_id', auth()->id());
    }

    public function scopeSemester(Builder $query, int $semester): void{
        $query->where('semester_id', $semester);
    }
}
