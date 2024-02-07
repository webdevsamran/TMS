<?php

use App\Jobs\ProcessMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ContributiontController;
use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* Login Routes */
Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('signin');

/* Register Routes */
Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register',[RegisterController::class,'register'])->name('signup');

Route::middleware(['user_verification'])->group(function(){
    /* Logout Routes */
    Route::get('/logout',[AdminController::class,'logout'])->name('logout');

    /* Dashboard Routes */
    Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');

    /* Project Routes */
    Route::get('/project', [ProjectController::class,'index'])->name('project');
    Route::get('/add_project',[ProjectController::class,'add_project'])->name('add_project');
    Route::post('/add_new_project',[ProjectController::class,'add_new_project'])->name('add_new_project');
    Route::get('/edit_project/{id}',[ProjectController::class,'edit_project'])->name('edit_project');
    Route::post('/edit_new_project/{id}',[ProjectController::class,'edit_new_project'])->name('edit_new_project');
    Route::get('/t/{id}',[ProjectController::class,'delete_project'])->name('delete_project');

    /* Task Routes */
    Route::get('/task',[TaskController::class,'index'])->name('task');
    Route::get('/add_task',[TaskController::class,'add_task'])->name('add_task');
    Route::post('/add_new_task',[TaskController::class,'add_new_task'])->name('add_new_task');
    Route::get('/edit_task/{id}',[TaskController::class,'edit_task'])->name('edit_task');
    Route::post('/update_task/{id}',[TaskController::class,'update_task'])->name('update_task');
    Route::get('/delete_task/{id}',[TaskController::class,'delete_task'])->name('delete_task');

    /* Contribution Routes */
    Route::get('/contribution', [ContributiontController::class,'index'])->name('contribution');
    Route::post('/add_contribution/{id}',[ContributiontController::class,'add_contribution'])->name('add_contribution');

    /* User Routes */
    Route::get('/user', [UserController::class,'index'])->name('user');
    Route::get('/add_user',[UserController::class,'add_user'])->name('add_user');
    Route::post('/add_new_user',[UserController::class,'add_new_user'])->name('add_new_user');
    Route::get('/edit_user/{id}',[UserController::class,'edit_user'])->name('edit_user');
    Route::post('/update_user/{id}',[UserController::class,'update_user'])->name('update_user');
    Route::get('/delete_user/{id}',[UserController::class,'delete_user'])->name('delete_user');

    /* Profile Routes */
    Route::get('/profile',[ProfileController::class,'index'])->name('profile');
    Route::get('/edit_profile',[ProfileController::class,'edit_profile'])->name('edit_profile');
    Route::post('/update_profile/{id}',[ProfileController::class,'update_profile'])->name('update_profile');

    /* Feedback Routes */
    Route::get('/feedback',[FeedbackController::class,'index'])->name('feedback');
    Route::get('/give_feedback/{id}',[FeedbackController::class,'give_feedback'])->name('give_feedback');
    Route::post('/add_new_feedback/{id}',[FeedbackController::class,'add_feedback'])->name('add_new_feedback');
});
