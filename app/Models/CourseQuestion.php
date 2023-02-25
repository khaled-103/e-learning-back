<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    protected $table = 'course_questions';
    protected $guarded = [];
    protected $appends = ['AnswersCount'];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(user::class);
    }
    public function responses()
    {
        return $this->hasMany(QuestionAnswers::class, 'question_id');
    }
    public function getCreatedAtAttribute(){
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
    public function getAnswersCountAttribute(){
        return QuestionAnswers::where('question_id',$this->attributes['id'])->count();
    }

}
