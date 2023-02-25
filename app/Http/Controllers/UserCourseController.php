<?php

namespace App\Http\Controllers;

use App\Models\CourseQuestion;
use App\Models\QuestionAnswers;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    use GeneralTrait;
    public function getCourseQuestions(Request $request)
    {
        $questions = CourseQuestion::where('course_id', $request->course_id)
            ->with(['user:username,id'])->latest()->get();
        return $this->returnData('questions', $questions, '');
    }
    public function getQuestionAnswers(Request $request)
    {
        $answers = QuestionAnswers::where('question_id', $request->question_id)
            ->with(['user:username,id,first_name'])->get(['id', 'body', 'created_at', 'user_id']);
        return $this->returnData('answers', $answers, '');
    }
    public function addQuestionCourse(Request $request)
    {
        $question = CourseQuestion::create([
            'course_id' => $request->course_id,
            'user_id' => $request->token['tokenable_id'],
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($question) {
            $question->load(['user:username,id']);
            return $this->returnData('question', $question, '');
        }
        return $this->returnError(429, 'something error');
    }
    public function deleteQuestionCourse(Request $request)
    {
        $question = CourseQuestion::where([
            'id' => $request->question_id,
            'user_id' => $request->token['tokenable_id'],
        ])->first();
        if ($question) {
            $question->delete();
            return $this->returnSuccessMessage('delete question success', '');
        }
        return $this->returnError(429, 'something error');
    }
    public function editQuestionCourse(Request $request)
    {
        $question = CourseQuestion::where([
            'id' => $request->question_id,
            'user_id' => $request->token['tokenable_id'],
        ])->first();
        if ($question) {
            $question->update([
                'title' => $request->title,
                'description' => $request->description
            ]);
            return $this->returnData('question', $question);
        }
        return $this->returnError(429, 'something error');
    }
    public function addQuestionReply(Request $request)
    {
        $answer = QuestionAnswers::create([
            'user_id' => $request->token['tokenable_id'],
            'question_id' => $request->question_id,
            'body' => $request->body
        ]);
        if ($answer) {
            $answer->load(['user:username,id,first_name']);
            return $this->returnData('answer', $answer);
        }
        return $this->returnError(429, 'something wrong happen');
    }
    public function deleteCourseReply(Request $request)
    {
        $answer = QuestionAnswers::where('id', $request->answer_id)->where('user_id', $request->token['tokenable_id'])->first();
        if($answer){
            $answer->delete();
            return $this->returnSuccessMessage('delete this answer success');
        }
        return $this->returnError(429,'something error happen');
    }
    public function editCourseReply(Request $request){
        $answer = QuestionAnswers::where('id', $request->answer_id)->where('user_id', $request->token['tokenable_id'])->first();
        if($answer){
            $answer->update([
                'body' => $request->body
            ]);
            return $this->returnSuccessMessage('update answer success');
        }
        return $this->returnError(429,'something error happen');
    }
}
