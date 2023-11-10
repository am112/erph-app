<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rph(){
        return $this->belongsTo(Rph::class);
    }

    public function field(){
        return $this->belongsTo(Select::class, 'field_id');
    }

    public function language(){
        return $this->belongsTo(Select::class, 'language_id');
    }

    public function standard(){
        return $this->belongsTo(Select::class, 'standard_id');
    }

    public function discipline(){
        return $this->belongsTo(Select::class, 'discipline_id');
    }
}
