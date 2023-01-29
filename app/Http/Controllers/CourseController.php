<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Course;
use App\Models\Language;
use App\Models\Rating;
use App\Models\Status;
use App\Models\Subscribe;
use App\Models\Tag;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Owenoj\LaravelGetId3\GetId3;


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

    public function getSubCategories()
    {
        $subCategories = Category::whereNotNull('parent_id')->get();
        return $this->returnData('subCategories', $subCategories, 'get SubCategories success');
    }

    public function getSelectedOrgCategories(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'id' => 'required|exists:orgnaizations,id',
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $categories = DB::table('orgnaization_categories')->where('orgnaization_id', $request->id)
            ->select('categories_id')->get();
        return $this->returnData('categories', $categories, 'get selected categories success');
    }


    public function getTags(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
        ], [
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.',
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError('validation error occur', $validator->errors(), 422);
        }
        $tags = Tag::whereCategoryId($request->category_id)->get(['id', 'name']);
        return $this->returnData('tags', $tags, 'Get tags successfully');
    }


    public function test(Request $request){
        $track = new GetId3($request->file('file'));
        return $track->getPlaytime();
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
            'level' => 'required|in:"All Levels", "Beginner", "Medium", "Advanced"',
            'teacher' => 'required',
            'image' => 'required|image',
            'tags' => 'required'
            // 'name' => 'required|min:8',
            // 'subtitle' => 'required|min:15|max:30',
            // 'description' => 'required|min:200',
            // 'price' => 'required|numeric',
            // 'language_id' => 'required|exists:languages,id',
            // 'category_id' => 'required|exists:categories,id',
            // 'level' => 'required|in:"All Levels", "Beginner", "Medium", "Advanced"'
        ], [
            'category_id.required' => 'Category field is required',
            'category_id.exists' => 'Invalid category',
            'language_id.required' => 'Language field is required',
            'language_id.exists' => 'Invalid language',
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $image_path = $file->store('/courses', [
                    'disk' => 'uploads'
                ]);

                $data = explode('/', $image_path);
                $image_path = $data[1];
            }
        }

        DB::beginTransaction();
        $course = Course::create([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image_path,
            'level' => $request->level,
            'oranization_id' => json_decode($request->token)->tokenable_id,
            'language_id' => $request->language_id,
            'category_id' => $request->category_id,
            'teacher' => $request->teacher,
            'slug' => Str::slug($request->name),
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
            $course->tags()->attach(json_decode($request->tags));
            DB::commit();
            return $this->returnSuccessMessage('Create Course success');
        }
        return $this->returnError(429, 'something wrong!!');
    }

    public function update(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => 'required|unique:courses,name,' . $request->course_id,
            'subtitle' => 'required',
            'description' => 'required',
            'teacher' => 'required',
            'price' => 'required|numeric',
            'language_id' => 'required|exists:languages,id',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|in:"All Levels", "Beginner", "Medium", "Advanced"',
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $course = Course::where('id', $request->course_id)
            ->where('oranization_id', json_decode($request->token)->tokenable_id)->first();
        $image_path = $course->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file && $file->isValid()) {
                if ($course->image != 'avatar.jpg')
                    Storage::disk('uploads')->delete('/' . $course->image);
                $image_path = $file->store('/courses', [
                    'disk' => 'uploads'
                ]);
                $arr = explode('/', $image_path);
                $image_path = $arr[1];
            }
        }

        if ($course) {
            DB::beginTransaction();
            $course->update([
                'name' => $request->name,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'teacher' => $request->teacher,
                'price' => $request->price,
                'level' => $request->level,
                'image' => $image_path,
                'language_id' => $request->language_id,
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->name),
            ]);
            $course->tags()->sync(json_decode($request->tags));
            DB::commit();
            return $this->returnData('courseImage',$course->image);
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
        $course = Course::with('tags:id,name')->where('id', $request->course_id)
            ->where('oranization_id', $request->token['tokenable_id'])->first();
        if ($course)
            return $this->returnData('course', $course, 'get course info success');
        return $this->returnError(429, 'something error! no data found');
    }

    public function getCourseStatus(Request $request)
    {
        $status = Status::where('course_id', $request->course_id)->first();
        return $this->returnData('courseStatus', $status, 'get status success');
    }
    public function changeCourseStatus(Request $request)
    {
        $course = Course::where('id', $request->course_id)->where('oranization_id', $request->token['tokenable_id'])->first();
        if ($course) {
            $status = Status::where('course_id', $request->course_id)->first();
            $status->update([
                'status' => $request->courseStatus
            ]);
            return $this->returnSuccessMessage('change State success');
        } else {
            return $this->returnError('Sumbit Failed', 429);
        }
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
