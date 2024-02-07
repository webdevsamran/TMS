<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiTaskController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiProfileController;
use App\Http\Controllers\Api\ApiProjectController;
use App\Http\Controllers\Api\ApiFeedbackController;
use App\Http\Controllers\Api\ApiRegisterController;
use App\Http\Controllers\Api\ApiContributionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register',[ApiRegisterController::class,'register']);
Route::post('/login',[ApiRegisterController::class,'login']);

Route::middleware(['auth:api'])->group( function () {
    /* Logout API */
    Route::get('/logout',[ApiRegisterController::class,'logout']);

    /* Projects APIs */
    Route::get('/all_project',[ApiProjectController::class,'index']);
    Route::get('/show_single_project/{id}',[ApiProjectController::class,'show']);
    Route::post('/store_project',[ApiProjectController::class,'store']);
    Route::post('/update_project/{id}',[ApiProjectController::class,'update']);
    Route::get('/destroy_project/{id}',[ApiProjectController::class,'destroy']);

    /* Tasks APIs */
    Route::get('/all_task',[ApiTaskController::class,'index']);
    Route::get('/show_single_task/{id}',[ApiTaskController::class,'show']);
    Route::post('/store_task',[ApiTaskController::class,'store']);
    Route::post('/update_task/{id}',[ApiTaskController::class,'update']);
    Route::get('/destroy_task/{id}',[ApiTaskController::class,'destroy']);

    /* Contribution APIs */
    Route::get('/contribution', [ApiContributionController::class,'index']);
    Route::post('/add_contribution/{id}',[ApiContributionController::class,'store']);

    /* User APIs */
    Route::get('/all_user', [ApiUserController::class,'index']);
    Route::get('/show_single_user/{id}',[ApiUserController::class,'show']);
    Route::post('/store_user',[ApiUserController::class,'store']);
    Route::post('/update_user/{id}',[ApiUserController::class,'update']);
    Route::get('/delete_user/{id}',[ApiUserController::class,'destroy']);

    /* Profile APIs */
    Route::get('/profile', [ApiProfileController::class,'index']);
    Route::post('/update_profile',[ApiProfileController::class,'update']);

    /* Feedback APIs */
    Route::get('/feedback',[ApiFeedbackController::class,'index']);
    Route::post('/give_feedback/{id}',[ApiFeedbackController::class,'store']);
});
