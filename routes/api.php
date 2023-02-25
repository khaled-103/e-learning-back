<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DetailCourseController;
use App\Http\Controllers\Orgnaiztion\Auth\AuthOrgController;
use App\Http\Controllers\Orgnaiztion\LectuerController;
use App\Http\Controllers\Orgnaiztion\OrgProfileController;
use App\Http\Controllers\Orgnaiztion\SectionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserCourseController;
use App\Models\CourseQuestion;
use App\Models\Tag;
use Illuminate\Http\Request;
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


Route::middleware('checkPassword')->group(function () {
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/checkToken', [AuthController::class, 'checkToken']);
    Route::post('/user/sendVerifyEmail', [AuthController::class, 'sendVerifyEmail'])->middleware('throttle:3');
    Route::post('/user/checkVerifyCode', [AuthController::class, 'checkVerifyCode']);
    Route::post('/user/sendCodeToEmail', [AuthController::class, 'sendCodeToEmail']);
    Route::post('/user/resetPassword', [AuthController::class, 'resetPassword']);


    Route::post('/orgnaization/sendVerifyEmail', [AuthOrgController::class, 'sendVerifyEmail'])->middleware('throttle:3');
    Route::post('/orgnaization/checkVerifyCode', [AuthOrgController::class, 'checkVerifyCode']);
    Route::post('/orgnaization/register', [AuthOrgController::class, 'register']);
    Route::post('/orgnaization/login', [AuthOrgController::class, 'login']);
    Route::post('/orgnaization/sendCodeToEmail', [AuthOrgController::class, 'sendCodeToEmail']);
    Route::post('/orgnaization/resetPassword', [AuthOrgController::class, 'resetPassword']);
    Route::post('/orgnaization/createCourse', [CourseController::class, 'store'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/updateCourse', [CourseController::class, 'update'])->middleware('MyAuth:orgnaization');

    Route::post('/orgnaization/allCourses', [CourseController::class, 'getOrgnaizationCourses'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/get-course-info', [CourseController::class, 'getCourseInfo'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/getCourseStatus', [CourseController::class, 'getCourseStatus']);
    Route::post('/orgnaization/changeCourseStatus', [CourseController::class, 'changeCourseStatus'])->middleware('MyAuth:orgnaization');




    Route::post('/getLanguages', [CourseController::class, 'getLanguages']);
    Route::post('/getCategories', [CourseController::class, 'getCategories']);
    Route::post('/getSubCategories', [CourseController::class, 'getSubCategories']);
    Route::post('/getSelectedOrgCategories', [CourseController::class, 'getSelectedOrgCategories']);


    Route::post('/getCountries', [OrgProfileController::class, 'getCountries']);
    Route::post('/orgnaization/getProfileInfo', [OrgProfileController::class, 'getProfileInfo'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/getProfileImage', [OrgProfileController::class, 'getProfileImage']);
    Route::post('/orgnaization/addNewCategory', [OrgProfileController::class, 'addNewCategory'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/deleteCategory', [OrgProfileController::class, 'deleteCategory'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/changeBasicInfo', [OrgProfileController::class, 'changeBasicInfo'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/profileChangePassword', [OrgProfileController::class, 'profileChangePassword'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/saveAdditionalInfoChanges', [OrgProfileController::class, 'saveAdditionalInfoChanges'])->middleware('MyAuth:orgnaization');

    Route::post('/orgnaization/allSections', [SectionController::class, 'allSection'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/addSection', [SectionController::class, 'store'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/updateSection', [SectionController::class, 'update'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/deleteSection', [SectionController::class, 'deleteSection'])->middleware('MyAuth:orgnaization');

    Route::post('/orgnaization/getLectuer', [LectuerController::class, 'index'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/allLectuer', [LectuerController::class, 'allLectuer'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/addLecture', [LectuerController::class, 'store'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/updateLecture', [LectuerController::class, 'updateLecture'])->middleware('MyAuth:orgnaization');
    Route::post('/orgnaization/deletelectre', [LectuerController::class, 'deletelectre'])->middleware('MyAuth:orgnaization');


    Route::post('/course/getQuestions', [UserCourseController::class, 'getCourseQuestions']);
    Route::post('/course/getAnswers', [UserCourseController::class, 'getQuestionAnswers']);
    Route::post('/course/addQuestionCourse', [UserCourseController::class, 'addQuestionCourse']); //add auth middleware user
    Route::post('/course/deleteQuestionCourse', [UserCourseController::class, 'deleteQuestionCourse']); //add auth middleware user
    Route::post('/course/editQuestionCourse', [UserCourseController::class, 'editQuestionCourse']); //add auth middleware user
    Route::post('/course/addQuestionReply', [UserCourseController::class, 'addQuestionReply']); //add auth middleware user
    Route::post('/course/deleteCourseReply', [UserCourseController::class, 'deleteCourseReply']); //add auth middleware user
    Route::post('/course/editCourseReply', [UserCourseController::class, 'editCourseReply']); //add auth middleware user
    Route::post('detailsCourse', [CourseController::class, 'detailsCourse']);
    Route::post('/getTags', [CourseController::class, 'getTags']);
    Route::post('/getTags', [CourseController::class, 'getTags']);
    Route::post('/getHomePageCourses', [CourseController::class, 'getHomePageCourses']);
    Route::post('/learn/getCourseContent', [CourseController::class, 'getCourseContent']);
    Route::post('addRatings', [DetailCourseController::class, 'addRatings']);
    Route::post('getRatesCourse', [DetailCourseController::class, 'getRatesCourse']);
    Route::post('/search', [CourseController::class, 'search']);
    Route::post('search/get-course-names', function (){
        return response()->json(Tag::select(['name'])->get());
    });
    Route::post('/checkUserPayStatus',[CourseController::class,'checkUserPayStatus']);
});
Route::post('/payment/createPaymentIntent',[PaymentController::class,'createPaymentIntent']);
Route::post('store/description-images', function (Request $request) {
    $image = $request->file('upload');
    $filename = time() . '.' . $image->getClientOriginalExtension();
    $path = $image->move(public_path('description_images'), $filename);

    return response()->json([
        'uploaded' => true,
        'url' => asset('description_images/' . $filename),
    ]);
});
Route::post('/testEmail', [AuthController::class, 'testEmail']);
Route::post('/test', [CourseController::class, 'test']);
