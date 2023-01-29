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
        return $this->hasOne(Rating::class);
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
    public function getImageAttribute(){
        return asset('uploads/images/org/courses/'.$this->attributes['image']);
    }
}
