<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

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
}
