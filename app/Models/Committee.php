<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $guarded = [];

    // ========================= global scope

    protected static function booted(): void
    {
        if(auth()->check()){
            static::addGlobalScope('owner', function(Builder $query){
                $query->where('user_id', auth()->id());
            });
        }
    }

    public function scopeSemester(Builder $query, int $semester): void{
        $query->where('semester_id', $semester);
    }
}
