<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function state(){
        return $this->belongsTo(Region::class, 'state_id');
    }

    public function parliment(){
        return $this->belongsTo(Region::class, 'parliment_id');
    }

    public function dun(){
        return $this->belongsTo(Region::class, 'dun_id');
    }
}
