<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Teacher extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'dob' => 'datetime',
    ];

    protected $appends = [
        'avatar'
    ];

    public const MEDIA_AVATAR = 'teacher_avatar';

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: function(null $value){
                $media = $this->getFirstMedia(Teacher::MEDIA_AVATAR);
                if($media == null){
                    return null;
                }
                if(in_array($media->disk, ['do', 's3'])){
                    $image = $media->getTemporaryUrl(now()->addMinutes(5));
                }else{
                    $image = $media->getUrl();
                }
                if ($image != null) {
                    return $image;
                }
                return null;
            },
        );
    }

    // =========================  scope ==============================

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
