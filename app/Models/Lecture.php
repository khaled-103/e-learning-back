<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','section_id','lecture_path','type','file_name','lecture_duration'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
