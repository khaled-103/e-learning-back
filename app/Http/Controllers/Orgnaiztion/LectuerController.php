<?php

namespace App\Http\Controllers\Orgnaiztion;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Orgnaization;
use App\Models\Section;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Owenoj\LaravelGetId3\GetId3;

class LectuerController extends Controller
{

    use GeneralTrait;

    public function index(Request $request)
    {
        $lecture = Lecture::where('section_id', $request->section_id)->findOrFail($request->lecture_id);
        if ($lecture) {
            return $this->returnData('lecture', Storage::url($lecture->lecture_path), 'get lectuers success');
        } else
            return $this->returnError(429, 'something wrong!!');
    }

    public function allLectuer(Request $request)
    {
        $sections_id = Section::where('course_id', $request->course_id)->get(['id']);
        $lectuers = Lecture::whereIn('section_id', $sections_id)->get();
        return $this->returnData('lectuers', $lectuers, 'get lectuers success');
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'title' => 'required',
            'lecture' => 'required',
            'section_id' => 'required|exists:sections,id',
        ]);

        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }

        $lecture_path = '';
        $type_file = '';
        $file_name='';
        $duration='00:00';
        $sec=0;
        if ($request->hasFile('lecture')) {
            $file = $request->file('lecture');
            $extention_file = $file->getClientOriginalExtension();
            $file_name=$file->getClientOriginalName();
            if ($extention_file == 'mp4') {
                $type_file = 'video';
                $lecture_path = $file->store('/', ['disk' => 'Video_lecture']);
                $track = new GetId3($request->file('lecture'));
                $duration =  $track->getPlaytime();
                $sec = $track->getPlaytimeSeconds();
            } else {
                $type_file = 'attachment';
                $lecture_path = $file->store('/', ['disk' => 'Attachment_lecture']);
            }
        }

        $lecture = Lecture::create([
            'section_id' => $request->section_id,
            'title' => $request->title,
            'type' => $type_file,
            'lecture_path' => $lecture_path,
            'file_name'=>$file_name,
            'lecture_duration' => $duration
        ]);

        if ($lecture) {
            $section = Section::find($request->section_id);
            $course = Course::find($section->course_id);
            $lecturesNumber = $course->lectures_number;
            $course->update([
                'course_duration' =>  $course->course_duration + $sec,
                'lectures_number' => ++$lecturesNumber,
            ]);
            return $this->returnData('lecture', $lecture, 'get lectuers success');
        } else
            return $this->returnError(429, 'something wrong!!');
    }

    public function updateLecture(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'title' => 'required',
            'lecture' => 'required',
            'section_id' => 'required|exists:sections,id',
            'lecture_id' => 'required|exists:lectures,id',
        ]);

        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $lecture = Lecture::where('section_id', $request->section_id)->findOrFail($request->lecture_id);

        $lecture_path = $lecture->lecture_path;
        $type_file = $lecture->type;
        $file_name=$lecture->file_name;
        $duration=$lecture->lecture_duration;
        if ($request->hasFile('lecture')) {

            $file = $request->file('lecture');
            $extention_file = $file->getClientOriginalExtension();
            $file_name = $file->getClientOriginalName();

            if ($extention_file == 'mp4') {
                $type_file = 'video';
                $lecture_path = $file->store('/', ['disk' => 'Video_lecture']);
                $track = new GetId3($request->file('lecture'));
                $duration =  $track->getPlaytime();
            } else {
                $type_file = 'attachment';
                $lecture_path = $file->store('/', ['disk' => 'Attachment_lecture']);
            }

            $this->deleteFromStorge($lecture);
        }
        $lecture->update([
            'section_id' => $request->section_id,
            'title' => $request->title,
            'type' => $type_file,
            'lecture_path' => $lecture_path,
            'file_name'=>$file_name,
            'lecture_duration' => $duration
        ]);

        if ($lecture) {
            return $this->returnSuccessMessage('update Lecture success');
        } else
            return $this->returnError(429, 'something wrong!!');
    }

    public function deletelectre(Request $request)

    {
        $section =Section::findOrFail($request->section_id);
        $course = Course::findOrFail($section->course_id);
        if($course->oranization_id == $request->token['tokenable_id']){
            $lecture = Lecture::where('section_id', $request->section_id)->findOrFail($request->lecture_id);

            if ($lecture) {
                $lecture->delete();
                $this->deleteFromStorge($lecture);

                return $this->returnData('lecture_path', $lecture, 'get lectuers success');
            } else
                return $this->returnError(429, 'something wrong!!');
        }
        return $this->returnError(429, 'Not Auth!!');
    }

    public function deleteFromStorge($lecture){

        $lecture_path = $lecture->lecture_path;
        $data = explode('.', $lecture_path);
        if ($data[1] == 'mp4') {
            Storage::disk('Video_lecture')->delete($lecture->lecture_path);
        } else {
            Storage::disk('Attachment_lecture')->delete($lecture_path);
        }
    }
}
