<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ComplainsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Hall_photoController;
use App\Http\Controllers\Hall_supervisorController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\RequstController;
use App\Http\Controllers\Supervisor_infoController;
use App\Http\Controllers\TeacheController;
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


Route::apiResource("complain",ComplainsController::class);
Route::apiResource("course",CourseController::class);
Route::apiResource("employee",EmployeeController::class);
Route::apiResource("hall",HallController::class);
Route::apiResource("requst",RequstController::class);
// Route::apiResource("supervisor_info",Supervisor_infoController::class);
// Route::apiResource("teache",TeacheController::class);
// Route::apiResource("hall_photo",Hall_photoController::class);
// Route::apiResource("hall_supervisor",Hall_supervisorController::class);
// Route::apiResource("booking",BookingController::class);


Route::get('getRequst/{request_num_id}',[RequstController::class,'showreq']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});








