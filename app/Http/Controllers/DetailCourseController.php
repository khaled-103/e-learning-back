<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Rating;
use App\Models\RatingCourse;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetailCourseController extends Controller
{
    use GeneralTrait;
    public function addRatings(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'rate' => 'required',
            'comment' => 'nullable',
            'course_id' => 'required',
        ]);

        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }

        $rate = Rating::create([
            'rate' => $request->rate,
            'comment' => $request->comment,
            'user_id' => $request->token['tokenable_id'],
            'course_id' => $request->course_id,
        ]);


        $ratingCourse = RatingCourse::where('course_id', $request->course_id)->first();

        if ($ratingCourse) {
            $ratingCourse->update([
                'numOfRate' => $ratingCourse->numOfRate + 1,
                'range_rate' => ($ratingCourse->range_rate * $ratingCourse->numOfRate + $request->rate) / ($ratingCourse->numOfRate + 1)
            ]);
            return $this->returnData('ratingCourse', [$ratingCourse, $rate]);
        } else {
            $ratingCourseNew = RatingCourse::create([
                'course_id' => $request->course_id,
                'range_rate' => $request->rate,
                'numOfRate' => 1
            ]);
            return $this->returnData('ratingCourse', [$ratingCourseNew, $rate]);
        }
    }

    public function getRatesCourse(Request $request)
    {
        $courseId = Course::where('slug',$request->course_slug)->first()->id;
        $rates = DB::select("SELECT ratings.id , ratings.rate , users.first_name , users.last_name , ratings.comment
         from ratings LEFT JOIN users ON ratings.user_id = users.id
         where ratings.course_id =$courseId LIMIT 4 OFFSET $request->offset ");

        return $this->returnData('ratings', $rates, '');
    }
}
