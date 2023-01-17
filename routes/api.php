<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Orgnaiztion\Auth\AuthOrgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('checkPassword')->group(function () {
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/checkToken', [AuthController::class, 'checkToken']);
    Route::post('/user/sendVerifyEmail', [AuthController::class, 'sendVerifyEmail'])->middleware('throttle:3');
    Route::post('/user/checkVerifyCode',[AuthController::class,'checkVerifyCode']);
    Route::post('/user/sendCodeToEmail',[AuthController::class,'sendCodeToEmail']);
    Route::post('/user/resetPassword',[AuthController::class,'resetPassword']);


    Route::post('/orgnaization/sendVerifyEmail', [AuthOrgController::class, 'sendVerifyEmail'])->middleware('throttle:3');
    Route::post('/orgnaization/checkVerifyCode',[AuthOrgController::class,'checkVerifyCode']);
    Route::post('/orgnaization/register', [AuthOrgController::class, 'register']);
    Route::post('/orgnaization/login', [AuthOrgController::class, 'login']);
    Route::post('/orgnaization/sendCodeToEmail',[AuthOrgController::class,'sendCodeToEmail']);
    Route::post('/orgnaization/resetPassword',[AuthOrgController::class,'resetPassword']);
    Route::post('/orgnaization/createCourse',[CourseController::class,'store'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/allCourses',[CourseController::class,'getOrgnaizationCourses'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/get-course-info',[CourseController::class,'getCourseInfo'])->middleware('MyAuth:orgnaization');


    Route::post('/getLanguages',[CourseController::class,'getLanguages']);
    Route::post('/getCategories',[CourseController::class,'getCategories']);
});



Route::post('/testEmail',[AuthController::class,'testEmail']);
// Route::post('/logout',[AuthOrgController::class,'logout']);
