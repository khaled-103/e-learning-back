<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Language;
use App\Models\Rating;
use App\Models\Status;
use App\Models\Subscribe;
use App\Traits\GeneralTrait;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Course::select(['id', 'name', 'description', 'price', 'image'])->get());
    }

    public function getLanguages()
    {
        $languages = Language::all();
        return $this->returnData('languages', $languages, 'get languages success');
    }
    public function getCategories()
    {
        $categories = Category::whereNull('parent_id')->get();
        return $this->returnData('categories', $categories, 'get Categories success');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'language_id' => 'required|exists:languages,id',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|in:"All Levels", "Beginner", "Medium", "Advanced"'
            // 'name' => 'required|min:8',
            // 'subtitle' => 'required|min:15|max:30',
            // 'description' => 'required|min:200',
            // 'price' => 'required|numeric',
            // 'image' => 'required|image',
            // 'language_id' => 'required|exists:languages,id',
            // 'category_id' => 'required|exists:categories,id',
            // 'level' => 'required|in:"All Levels", "Beginner", "Medium", "Advanced"'
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }

        $image_name = "";
        if ($request->file('value')) {
            $image = $request->file('value');
            $image_name = $request->name . "." . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/'), $image_name);
        }
        $course = Course::create([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image_name,
            'oranization_id' => $request->token['tokenable_id'],
            'language_id' => $request->language_id,
            'category_id' => $request->category_id
        ]);
        if ($course) {
            Rating::create([
                'course_id' => $course->id,
                'rate' => 0,
                'numOfRate' => 0,
            ]);
            Subscribe::create([
                'course_id' => $course->id,
                'numOfSubscribe' => 0
            ]);
            Status::create([
                'course_id' => $course->id,
                'status' => 'not publish'
            ]);
            return $this->returnSuccessMessage('Create Course success');
        }
        return $this->returnError(429, 'something wrong!!');
    }

    public function getOrgnaizationCourses(Request $request)
    {
        $courses = Course::where('oranization_id', $request->token['tokenable_id'])
            ->with(['rating:rate,course_id', 'subscribe:numOfSubscribe,course_id', 'status:status,course_id'])
            ->select(['id', 'name', 'price', 'created_at'])
            ->latest()->get();
        if ($courses)
            return $this->returnData('courses', $courses, 'Get Orgnaization courses success');
        return $this->returnError(429, 'something error! no data found');
    }


    public function getCourseInfo(Request $request)
    {
        $course = Course::where('id', $request->course_id)
        ->where('oranization_id', $request->token['tokenable_id'])->first();
        if($course)
            return $this->returnData('course', $course, 'get course info success');
        return $this->returnError(429, 'something error! no data found');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
