<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    use GeneralTrait;

    

    public function addCourseInCart(Request $request)
    {
        $item= Cart::create([
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
        ]);
        return $this->returnData('item',$item, 'get course content successfully');
    }

    public function getItemsCart(Request $request)
    {
        $itemsCart = DB::select("SELECT courses.id ,courses.slug ,courses.image ,courses.level ,courses.discount, courses.name, courses.price , rate.range_rate , rate.numOfRate  , org.name as orgName from courses
        left join carts on courses.id = carts.course_id
        left join rating_courses as rate on courses.id = rate.course_id
        left join orgnaizations as org on courses.oranization_id = org.id
        where  $request->user_id = carts.user_id");
        return $this->returnData('itemsCart',$itemsCart, 'get course content successfully');

    }

    public function checkCourseInCart(Request $request){
        $item = DB::select("SELECT * from carts where user_id = $request->user_id and course_id = $request->course_id ");
        if($item){
            return $this->returnData('checkCourseInCart','addCart');
        }
        return $this->returnData('checkCourseInCart','not addCart');
    }

    public function removeCourseFromCart(Request $request)
    {
        $item = DB::delete("DELETE FROM  carts where user_id = $request->user_id and course_id = $request->course_id ");
        if($item){
            return $this->returnData('sussecc',$item);
        }
        else {
            return $this->returnError(429, 'item not exsite');
        }

    }

    public function removeAllItemsFromCart(Request $request){
        $items = DB::delete("DELETE FROM  carts where user_id = $request->user_id");
        if($items){
            return $this->returnData('sussecc',$items);
        }
        else {
            return $this->returnError(429, 'not success delete all items');
        }
    }
}
