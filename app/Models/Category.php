<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['slug'];
    public function courses(){
        return $this->hasMany(Course::class);
    }
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
    public function getSlugAttribute($key)
    {
        return Str::slug($this->name);
    }
}
