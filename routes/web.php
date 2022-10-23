<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\PublicUserController;
use App\Http\Controllers\PublicindexController;
use App\Http\Controllers\TeamController;
use App\Models\Team\TeamModel;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminIndexController;
use App\Http\Controllers\AdminQuestionController;
use App\Http\Controllers\PublicQuestionController;
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

Route::get('/',[PublicindexController::class,'index']);
Route::group(['prefix'=>'public'],function (){
    Route::get('/questions',[PublicindexController::class,'questions']);
    Route::get('/logout',[PublicUserController::class,'logout']);
    Route::post('/enroll',[PublicUserController::class,'signup']);
    Route::post('/pulogin',[PublicUserController::class,'login']);
    Route::get('/index',[PublicindexController::class,'index']);
    Route::get('/ucenter',[PublicindexController::class,'ucenter']);
    Route::get('/signup',function(){
        return view('signup');
    });
    Route::get('/login', function () {
        return view('login');
    });
    Route::post('/download',[PublicQuestionController::class,'download']);
    Route::post('/questions/flag_submit',[PublicQuestionController::class,'flag_submit']);
    Route::group(['prefix'=>'team'],function (){
        Route::post('create',[TeamController::class,'create']);
        Route::post('apply',[TeamController::class,'apply']);
        Route::post('accept',[TeamController::class,'accept']);
        Route::post('teamchange',[TeamController::class,'Teamchange']);
    });
});
Route::post('/create_docker',[PublicQuestionController::class,'create_docker']);



Route::group(['prefix'=>'admin'],function (){
    Route::get('/page/login',function (){
        return view('managerlogin');
    });
    Route::get('/index',[AdminIndexController::class,'index']);
    Route::post('/login',[AdminController::class,'login']);
    Route::get('/question_manage',[AdminQuestionController::class,'question_manage']);
    Route::post('/question_upload',[AdminQuestionController::class,'Qu_upload']);
    Route::get('/logout',[AdminController::class,'logout']);
    Route::post('/question_remove',[AdminQuestionController::class,'remove_question']);
    Route::post('/userchange',[AdminController::class,'userchange']);
    Route::post('/teamchange',[AdminController::class,'teamchange']);
});
