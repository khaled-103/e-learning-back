<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Language;
use App\Models\Lecture;
use App\Models\Orgnaization;
use App\Models\Rating;
use App\Models\RatingCourse;
use App\Models\Section;
use App\Models\Status;
use App\Models\Subscribe;
use App\Models\Tag;
use App\Traits\GeneralTrait;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Nette\Utils\Json;
use Owenoj\LaravelGetId3\GetId3;


class CourseController extends Controller
{
    use GeneralTrait;

    public function test(Request $request)
    {
        $lecture = Lecture::latest()->first();

        return $this->returnData('lects',$lecture);
    }


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
    public function getAllCategories()
    {
        $allCategories = Category::all(['id', 'name', 'parent_id']);
        return $this->returnData('allCategories', $allCategories, 'get allCategories success');
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

    public function getCoursesInCategory(Request $request)
    {
        $courses = Course::with(['rating:range_rate,numOfRate,course_id', 'language:id,language'])->where('category_id', $request->categoryId)->get();
        return $this->returnData('courses', $courses, '');
        // $courses = DB::select("SELECT courses.id ,courses.slug  ,courses.image, courses.name as courseName , courses.price ,courses.category_id , rate.range_rate , rate.numOfRate , org.name as orgName
        //     from courses left  join rating_courses as rate on courses.id = rate.course_id
        //     left join orgnaizations as org on courses.oranization_id = org.id
        //     and courses.category_id = $request->categoryId
        //     order by rate.numOfRate * rate.range_rate desc");
        // return $this->returnData('courses', $courses);
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




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function upload(Request $request){
        $video_path = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $video_path = $file->store('/', [
                    'disk' => 'Video_lecture'
                ]);
            }
        }
        return response()->json(['path' => $video_path]);
    }
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
            'video' => 'nullable|mimes:mp4',
            'requirements' => 'required',
            'objectives' => 'required',
            // 'tags' => 'required'
            'tags' => 'nullable'
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

        $video_path = null;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            if ($file->isValid()) {
                $video_path = $file->store('/', [
                    'disk' => 'Courses_video'
                ]);
            }
        }

        DB::beginTransaction();
        $course = Course::create([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image_path,
            'video' => $video_path,
            'level' => $request->level,
            'oranization_id' => json_decode($request->token)->tokenable_id,
            'language_id' => $request->language_id,
            'category_id' => $request->category_id,
            'teacher' => $request->teacher,
            'slug' => Str::slug($request->name),
            'requirements' => json_encode($request->requirements),
            'objectives' => json_encode($request->objectives)
        ]);
        if ($course) {
            RatingCourse::create([
                'course_id' => $course->id,
                'range_rate' => 0,
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
            'video' => 'nullable|mimes:mp4',
            'requirements' => 'required',
            'objectives' => 'required',
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $course = Course::where('id', $request->course_id)
            ->where('oranization_id', 1)->first();

        $image = explode('/', $course->image);
        $image_path = $image[count($image) - 1];
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
        $video = explode('/', $course->video);
        $video_path = $video[count($video) - 1];
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            if ($file->isValid()) {
                if ($course->video != null) {
                    $data = explode('/', $course->video);
                    Storage::disk('Courses_video')->delete($data[count($data) - 1]);
                }
                $video_path = $file->store('/', [
                    'disk' => 'Courses_video'
                ]);
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
                'video' => $video_path,
                'requirements' => json_encode($request->requirements),
                'objectives' => json_encode($request->objectives)
            ]);
            $course->tags()->sync(json_decode($request->tags));
            DB::commit();
            return $this->returnData('courseImage', $course->image);
        }
        return $this->returnError(429, 'something wrong!!');
    }
    public function detailsCourse(Request $request)
    {
        $course = Course::with(['sections', 'rating:range_rate,numOfRate,course_id'])->where('slug', $request->course_slug)->first();
        $sections_id = Section::where('course_id', $course->id)->get(['id']);
        $organization = Orgnaization::where('id', $course->oranization_id)->first();
        $language = Language::where('id', $course->language_id)->first();
        $lectures = Lecture::whereIn('section_id', $sections_id)->orderBy('created_at', 'desc')->get();
        $Last_update = $lectures->first();

        if ($course) {
            if ($Last_update == null) {
                $Last_update = '';
            } else {
                $Last_update = $Last_update->created_at->locale('is_IS')->isoFormat('Do MMM.YYYY');
            }
            return $this->returnData(
                'detail',
                array(
                    'lastUpdate' => $Last_update, 'course' => $course, 'organization' => $organization->name,
                    'lectures' => $lectures, 'language' => $language
                ),
                'get course info success'
            );
        }
        return $this->returnError(429, 'something error! no data found');
    }

    // public function store(Request $request)
    // {




    //     $Validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'subtitle' => 'required',
    //         'description' => 'required',
    //         'price' => 'required|numeric',
    //         'language_id' => 'required|exists:languages,id',
    //         'category_id' => 'required|exists:categories,id',
    //         'level' => 'required|in:"All Levels", "Beginner", "Medium", "Advanced"',
    //         'teacher' => 'required',
    //         'image' => 'required|image',
    //         'tags' => 'required'
    //         // 'name' => 'required|min:8',
    //         // 'subtitle' => 'required|min:15|max:30',
    //         // 'description' => 'required|min:200',
    //         // 'price' => 'required|numeric',
    //         // 'language_id' => 'required|exists:languages,id',
    //         // 'category_id' => 'required|exists:categories,id',
    //         // 'level' => 'required|in:"All Levels", "Beginner", "Medium", "Advanced"'
    //     ], [
    //         'category_id.required' => 'Category field is required',
    //         'category_id.exists' => 'Invalid category',
    //         'language_id.required' => 'Language field is required',
    //         'language_id.exists' => 'Invalid language',
    //     ]);
    //     if ($Validator->fails()) {
    //         return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
    //     }

    //     $image_path = null;
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         if ($file->isValid()) {
    //             $image_path = $file->store('/courses', [
    //                 'disk' => 'uploads'
    //             ]);

    //             $data = explode('/', $image_path);
    //             $image_path = $data[1];
    //         }
    //     }

    //     DB::beginTransaction();
    //     $course = Course::create([
    //         'name' => $request->name,
    //         'subtitle' => $request->subtitle,
    //         'description' => $request->description,
    //         'price' => $request->price,
    //         'image' => $image_path,
    //         'level' => $request->level,
    //         'oranization_id' => json_decode($request->token)->tokenable_id,
    //         'language_id' => $request->language_id,
    //         'category_id' => $request->category_id,
    //         'teacher' => $request->teacher,
    //         'slug' => Str::slug($request->name),
    //     ]);
    //     if ($course) {
    //         Rating::create([
    //             'course_id' => $course->id,
    //             'rate' => 0,
    //             'numOfRate' => 0,
    //         ]);
    //         Subscribe::create([
    //             'course_id' => $course->id,
    //             'numOfSubscribe' => 0
    //         ]);
    //         Status::create([
    //             'course_id' => $course->id,
    //             'status' => 'not publish'
    //         ]);
    //         $course->tags()->attach(json_decode($request->tags));
    //         DB::commit();
    //         return $this->returnSuccessMessage('Create Course success');
    //     }
    //     return $this->returnError(429, 'something wrong!!');
    // }

    // public function update(Request $request)
    // {
    //     $Validator = Validator::make($request->all(), [
    //         'name' => 'required|unique:courses,name,' . $request->course_id,
    //         'subtitle' => 'required',
    //         'description' => 'required',
    //         'teacher' => 'required',
    //         'price' => 'required|numeric',
    //         'language_id' => 'required|exists:languages,id',
    //         'category_id' => 'required|exists:categories,id',
    //         'level' => 'required|in:"All Levels", "Beginner", "Medium", "Advanced"',
    //     ]);
    //     if ($Validator->fails()) {
    //         return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
    //     }
    //     $course = Course::where('id', $request->course_id)
    //         ->where('oranization_id', json_decode($request->token)->tokenable_id)->first();
    //     $image_path = $course->image;
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         if ($file && $file->isValid()) {
    //             if ($course->image != 'avatar.jpg')
    //                 Storage::disk('uploads')->delete('/' . $course->image);
    //             $image_path = $file->store('/courses', [
    //                 'disk' => 'uploads'
    //             ]);
    //             $arr = explode('/', $image_path);
    //             $image_path = $arr[1];
    //         }
    //     }

    //     if ($course) {
    //         DB::beginTransaction();
    //         $course->update([
    //             'name' => $request->name,
    //             'subtitle' => $request->subtitle,
    //             'description' => $request->description,
    //             'teacher' => $request->teacher,
    //             'price' => $request->price,
    //             'level' => $request->level,
    //             'image' => $image_path,
    //             'language_id' => $request->language_id,
    //             'category_id' => $request->category_id,
    //             'slug' => Str::slug($request->name),
    //         ]);
    //         $course->tags()->sync(json_decode($request->tags));
    //         DB::commit();
    //         return $this->returnData('courseImage',$course->image);
    //     }
    //     return $this->returnError(429, 'something wrong!!');
    // }


    public function getOrgnaizationCourses(Request $request)
    {
        $courses = Course::where('oranization_id', $request->token['tokenable_id'])
            ->with(['rating:range_rate,course_id', 'subscribe:numOfSubscribe,course_id', 'status:status,course_id'])
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

    public function getCourseContent(Request $request)
    {
        //check token and it enroll this course
        $course = Course::where('slug', $request->course_slug)->select(['id', 'name', 'course_duration'])->first();
        $sections = Section::where('course_id', $course->id)->with('lectures')->get();
        return $this->returnData('courseContent', ['course' => $course, 'sections' => $sections], 'get course content successfully');
    }
    public function getHomePageCourses(Request $request)
    {
        $intersted = json_decode($request->cookieInterest);
        // return $intersted;
        $placeholders = implode(',', array_fill(0, count($intersted), '?'));
        $higthestRate = DB::select('SELECT courses.id, courses.slug ,courses.image , courses.name as courseName , courses.price ,courses.category_id , rate.range_rate , rate.numOfRate , org.name as orgName
         from courses left  join rating_courses as rate on courses.id = rate.course_id
        left join orgnaizations as org on courses.oranization_id = org.id
        where rate.range_rate >= 3 and rate.numOfRate >=100
        order by rate.numOfRate * rate.range_rate desc
        limit 15');

        if ($request->has('cookieInterest') && $intersted)
            $latestCourse = DB::select("SELECT courses.id ,courses.slug ,courses.image , courses.name as courseName , courses.price , rate.range_rate , rate.numOfRate , courses.category_id , org.name as orgName from courses
            left join rating_courses as rate on courses.id = rate.course_id
            left join orgnaizations as org on courses.oranization_id = org.id
            where courses.category_id IN ($placeholders)
            order by courses.id desc limit 15", $intersted);
        else {
            $latestCourse = DB::select("SELECT courses.id ,courses.slug ,courses.image , courses.name as courseName , courses.price ,courses.category_id , rate.range_rate , rate.numOfRate , org.name as orgName from courses
            left join rating_courses as rate on courses.id = rate.course_id
            left join orgnaizations as org on courses.oranization_id = org.id
            order by courses.id desc
            limit 15");
        }
        $recommendCourse = null;

        if ($request->has('cookieInterest') && $intersted)
            $recommendCourse = DB::select("SELECT courses.id ,courses.slug ,courses.image , courses.name as courseName , courses.price , rate.range_rate , rate.numOfRate , courses.category_id , org.name as orgName from courses
            left join rating_courses as rate on courses.id = rate.course_id
            left join orgnaizations as org on courses.oranization_id = org.id
            where courses.category_id IN ($placeholders)
            order by rand() limit 15", $intersted);


        $topCat = DB::select("SELECT cat.id , cat.name ,count(courses.id)
            from courses left join categories as cat on courses.category_id = cat.id
            Group by courses.category_id
            order by count(courses.id) desc
            limit 5");

        $coursesTopCategory = [];

        for ($i = 0; $i < sizeof($topCat); $i++) {
            $id = $topCat[$i]->id;
            $x = DB::select("SELECT courses.id ,courses.slug  ,courses.image, courses.name as courseName , courses.price ,courses.category_id , rate.range_rate , rate.numOfRate , org.name as orgName
            from courses left  join rating_courses as rate on courses.id = rate.course_id
            left join orgnaizations as org on courses.oranization_id = org.id
            where rate.range_rate >= 3 and rate.numOfRate >=100 and courses.category_id = $id
            order by rate.numOfRate * rate.range_rate desc Limit 10");
            $coursesTopCategory[$topCat[$i]->name] = $x;
        }
        return $this->returnData('homePageSections', [
            'higthestRate' => $higthestRate,
            'latestCourse' => $latestCourse,
            'recommendCourse' => $recommendCourse,
            'topCat' => $topCat,
            'coursesTopCategory' => $coursesTopCategory
        ]);
        // return $this->returnData('higthestRate',$higthestRate ,'');
    }






    public function myLearningGetItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError('validation error occur', $validator->errors());
        }
        $course_id = CourseRegistration::where('user_id', $request->user_id)->get('course_id');
        $result = Course::with('rating:range_rate,numOfRate,course_id')->find($course_id);

        return $this->returnData('result', $result, 'get My Learning items successfully');
    }





    public function search(Request $request)
    {
        $course = Course::with(['rating:range_rate,numOfRate,course_id', 'language:id,language'])->where('name', 'like', '%' . $request->name . '%')->orWhere('subtitle', 'like', '%' . $request->name . '%')
            ->get();
        return $this->returnData('course', $course, '');
    }


    public function checkUserPayStatus(Request $request)
    {
        $id = Course::where('slug', $request->course_slug)->first()->id;
        $res = CourseRegistration::where('user_id', $request->user_id)->where('course_id', $id)->first();
        if ($res) {
            return $this->returnData('userStatus', 'register');
        }
        return $this->returnData('userStatus', 'not register');
    }
}
