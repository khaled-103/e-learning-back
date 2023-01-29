<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $hidden = ['pivot'];


    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_tags');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
