<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswers extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'course_questions_answers';
    public function user(){
        return $this->belongsTo(user::class);
    }
    public function getCreatedAtAttribute(){
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

}
