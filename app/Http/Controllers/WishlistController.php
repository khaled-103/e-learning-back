<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Wishlist;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    use GeneralTrait;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        if($validator->fails()) {
            return $this->returnValidationError('validation error occur', $validator->errors());
        }

        Wishlist::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
        ]);

        return $this->returnSuccessMessage('wishlistItem added successfully', 200);
    }

    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        if($validator->fails()) {
            return $this->returnValidationError('validation error occur', $validator->errors());
        }

        $item = Wishlist::where([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
        ])->get();

        if(count($item) > 0)
            return $this->returnSuccessMessage('wishlist found element success', 200);
        else
            return $this->returnError(404, 'wishlist not found element');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        if($validator->fails()) {
            return $this->returnValidationError('validation error occur', $validator->errors());
        }

        Wishlist::whereUserId($request->user_id)->whereCourseId($request->course_id)->delete();
        return $this->returnSuccessMessage('wishlistItem deleted successfully', 200);
    }

    public function getItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if($validator->fails()) {
            return $this->returnValidationError('validation error occur', $validator->errors());
        }
        $ids = Wishlist::whereUserId($request->user_id)->get('course_id');
        $courses = Course::with('rating:range_rate,numOfRate,course_id')->whereIn('id', $ids)->get();

        return $this->returnData('courses', $courses, 'get wishlist items successfully');
    }
}
