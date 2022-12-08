<?php

use App\Http\Controllers\Auth\AuthController;
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

Route::post('/user/register',[AuthController::class,'register']);
Route::post('/user/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);

Route::post('/orgnaization/register',[AuthOrgController::class,'register']);
Route::post('/orgnaization/login',[AuthOrgController::class,'login']);
// Route::post('/logout',[AuthOrgController::class,'logout']);

Route::post('/getIp',[AuthController::class,'getIp']);
