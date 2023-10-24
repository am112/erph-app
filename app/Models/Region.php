<?php

namespace App\Models;

use App\Enums\RegionTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Region extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function ancestor(){
        return $this->belongsTo(Region::class, 'parent_id');
    }

    public function scopeState(Builder $query): void{
        $query->where('tag', RegionTag::STATE);
    }

    public function scopeParliment(Builder $query): void{
        $query->where('tag', RegionTag::PARLIMENT);
    }

    public function scopeDun(Builder $query): void{
        $query->where('tag', RegionTag::DUN);
    }
}
