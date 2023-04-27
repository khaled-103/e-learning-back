<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['pivot'];
    protected $appends = ['duration'];
    public function getDurationAttribute(){
        $seconds = $this->course_duration;
        $min = $seconds / 60;
        if ($min < 60) {
            return $min == 1 ? "$min minute" : floor($min) . " minutes";
        } else {
            $hours = round($min / 60, 1);
            return $hours == 1 ? "$hours hour" : "$hours hours";
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function organization()
    {
        return $this->belongsTo(organization::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function rating()
    {
        return $this->hasOne(RatingCourse::class);
    }
    public function subscribe()
    {
        return $this->hasOne(Subscribe::class);
    }
    public function status()
    {
        return $this->hasOne(Status::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'course_tags');
    }
    public function getImageAttribute()
    {
        return asset('uploads/images/org/courses/' . $this->attributes['image']);
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function getVideoAttribute()
    {
        return asset('courses/videos/' . $this->attributes['video']);
    }
    public function getRequirementsAttribute()
    {
        return json_decode($this->attributes['requirements']);
    }
    public function getObjectivesAttribute()
    {
        return json_decode($this->attributes['objectives']);
    }

}
