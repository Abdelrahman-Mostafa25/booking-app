<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\Hall_photoController;
use App\Http\Controllers\Hall_supervisorController;
use App\Http\Controllers\RequstController;
use App\Http\Controllers\Supervisor_infoController;
use App\Http\Controllers\TeacheController;
use App\Models\Requst;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/teache/{employee_num_id}/{course_code}',[TeacheController::class,'show']);
// Route::get('/teache',[TeacheController::class,'index']);
// Route::post('/teache',[TeacheController::class,'store']);
// Route::delete('/teache/{employee_num_id}/{course_code}',[TeacheController::class,'destroy']);
// Route::put('/teache/{employee_num_id}/{course_code}',[TeacheController::class,'update']);
////////////////////////////////////////
// Route::get('/booking/{employee_num_id}/{hall_num_id}',[BookingController::class,'show']);
// Route::get('/booking',[BookingController::class,'index']);
// Route::post('/booking',[BookingController::class,'store']);
// Route::delete('/booking/{id}/{employee_num_id}/{hall_num_id}',[BookingController::class,'destroy']);
// Route::put('/booking/{id}/{employee_num_id}/{hall_num_id}',[BookingController::class,'update']);

////////////////////////////////////////
Route::get('/hall_supervisor/{hall_num_id}',[Hall_supervisorController::class,'show']);
Route::get('/hall_supervisor',[Hall_supervisorController::class,'index']);
Route::post('/hall_supervisor',[Hall_supervisorController::class,'store']);
Route::delete('/hall_supervisor/{hall_num_id}/{counter_id}',[Hall_supervisorController::class,'destroy']);
Route::put('/hall_supervisor/{hall_num_id}/{counter_id}',[Hall_supervisorController::class,'update']);

////////////////////////////////////////
Route::get('/supervisor_info/{counter_id}',[Supervisor_infoController::class,'show']);
Route::get('/supervisor_info',[Supervisor_infoController::class,'index']);
Route::post('/supervisor_info',[Supervisor_infoController::class,'store']);
Route::delete('/supervisor_info/{counter_id}/{phone_num}',[Supervisor_infoController::class,'destroy']);
Route::put('/supervisor_info/{counter_id}/{phone_num}',[Supervisor_infoController::class,'update']);

////////////////////////////////////////
Route::get('/hall_photo/{hall_num_id}',[Hall_photoController::class,'show']);
Route::get('/hall_photo',[Hall_photoController::class,'index']);
Route::post('/hall_photo',[Hall_photoController::class,'store']);
Route::delete('/hall_photo/{hall_num_id}/{counter_id}',[Hall_photoController::class,'destroy']);
Route::put('/hall_photo/{hall_num_id}/{counter_id}',[Hall_photoController::class,'update']);
////////////////////////////////////

Route::get('/filter/{day_date}/{start_time}/{end_time}/{hall_type}/{capacity_hall}',[FilterController::class,'show']);

////////////////////////////////////////
// Route::get('/requst/{employee_num_id}',[RequstController::class,'show']);
// Route::get('/requst',[RequstController::class,'index']);
// Route::post('/requst',[RequstController::class,'store']);
// Route::delete('/requst/{request_num_id}',[RequstController::class,'destroy']);
// Route::put('/requst/{request_num_id}',[RequstController::class,'update']);

////////////////////////////////////


Route::get('/', function () {
    return view('welcome');
});
