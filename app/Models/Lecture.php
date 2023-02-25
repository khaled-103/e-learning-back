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
    public function getLecturePathAttribute(){
        if($this->attributes['type'] == 'video')
            return asset('video_lecture/'.$this->attributes['lecture_path']);
        return asset('attachment_lecture/'.$this->attributes['lecture_path']);
    }
}
