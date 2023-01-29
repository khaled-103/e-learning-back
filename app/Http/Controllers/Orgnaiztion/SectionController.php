<?php

namespace App\Http\Controllers\Orgnaiztion;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use App\Traits\GeneralTrait;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class SectionController extends Controller
{
    use GeneralTrait;

    public function allSection(Request $request)
    {
        // $sections = Section::all();
        $sections = Section::where('course_id', $request->course_id)->get();
        return $this->returnData('sections', $sections, 'get sections success');
    }

    public function store(Request $request)
    {

        $Validator = FacadesValidator::make($request->all(), [
            'name' => 'required',
            'course_id' => 'required|exists:courses,id'
        ]);

        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }

        $section = Section::create([
            'name' => $request->name,
            'course_id' => $request->course_id
        ]);

        if ($section) {
            // return response()->json(['message' => 'Create Section success']);
            // return $this->returnSuccessMessage('Create Section success');
            return $this->returnData('section', $section, 'store sections success');
        } else
            return $this->returnError(429, 'something wrong!!');
    }

    public function update(Request $request)
    {

        $Validator = FacadesValidator::make($request->all(), [
            'name' => 'required',
            'course_id' => 'required|exists:courses,id'
        ]);

        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $section = Section::where('course_id', $request->course_id)->findOrFail($request->section_id);

        $section->update([
            'name' => $request->name,
            'course_id' => $request->course_id
        ]);

        if ($section) {
            // return response()->json(['message' => 'Create Section success']);
            return $this->returnData('section', $section, 'update sections success');
        } else
            return $this->returnError(429, 'something wrong!!');
    }

    public function deleteSection(Request $request)
    {
        $course = Course::findOrFail($request->course_id);
        if ($course->oranization_id == $request->token['tokenable_id']) {
            $section = Section::where('course_id', $request->course_id)->findOrFail($request->section_id);
            $section->delete();
            if ($section) {
                // return response()->json(['message' => 'Create Section success']);
                return $this->returnSuccessMessage('Delete Section success');
            } else
                return $this->returnError(429, 'something wrong!!');
        }
        return $this->returnError(429, 'Not Auth!!');
    }
}
