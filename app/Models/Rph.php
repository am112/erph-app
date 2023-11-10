<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Rph extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public const MEDIA_MIND_MAP = 'rph_media_mind_map';
    public const MEDIA_WEB_ACTIVITY = 'rph_media_web_activity';

    protected $appends = [
        'mind_map',
        'web_activity',
    ];

    protected function mindMap(): Attribute
    {
        return Attribute::make(
            get: function(null $value){
                $media = $this->getFirstMedia(Rph::MEDIA_MIND_MAP);
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

    protected function webActivity(): Attribute
    {
        return Attribute::make(
            get: function(null $value){
                $media = $this->getFirstMedia(Rph::MEDIA_WEB_ACTIVITY);
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

    public function week(){
        return $this->belongsTo(Week::class);
    }

    public function timetables(){
        return $this->hasMany(Timetable::class);
    }

    // =========================  scope ==============================

    public function scopeCreatedBy(Builder $query): void{
        $query->where('user_id', auth()->id());
    }

    public function scopeSemester(Builder $query, int $semester): void{
        $query->where('semester_id', $semester);
    }
}
