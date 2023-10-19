<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KokurikulumUser extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'kokurikulum_user';

    protected $casts = [
        'plan_started_at' => 'datetime:Y-m-d',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function semester(){
        return $this->belongsTo(Semester::class);
    }

    public function kokurikulum(){
        return $this->belongsTo(Kokurikulum::class);
    }
}
