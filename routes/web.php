<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Hall_supervisorController;
use App\Http\Controllers\TeacheController;
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
Route::get('/teache/{id1}/{id2}',[TeacheController::class,'show']);
Route::get('/teache',[TeacheController::class,'index']);
Route::post('/teache',[TeacheController::class,'store']);
Route::delete('/teache/{id1}/{id2}',[TeacheController::class,'destroy']);
Route::put('/teache/{id1}/{id2}',[TeacheController::class,'update']);
////////////////////////////////////////
Route::get('/booking/{id1}/{id2}',[BookingController::class,'show']);
Route::get('/booking',[BookingController::class,'index']);
Route::post('/booking',[BookingController::class,'store']);
Route::delete('/booking/{id1}/{id2}',[BookingController::class,'destroy']);
Route::put('/booking/{id1}/{id2}',[BookingController::class,'update']);

////////////////////////////////////////
Route::get('/hall_supervisor/{id1}',[Hall_supervisorController::class,'show']);
Route::get('/hall_supervisor',[Hall_supervisorController::class,'index']);
Route::post('/hall_supervisor',[Hall_supervisorController::class,'store']);
Route::delete('/hall_supervisor/{id1}/{id2}',[Hall_supervisorController::class,'destroy']);
Route::put('/hall_supervisor/{id1}/{id2}',[Hall_supervisorController::class,'update']);


Route::get('/', function () {
    return view('welcome');
});
