<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Web'], function(){
   Route::get('/', 'HomeController@index')->name('home');
});

/*BackgroupController - Cloner*/
Route::group(['prefix' => 'background'],function (){
    //cloner
    Route::group(['prefix' => 'cloner'],function (){
        Route::get('/courses','BackgroundController@cloneCourses');
        Route::get('/lessons','BackgroundController@cloneLessons');
        Route::get('/words','BackgroundController@cloneWords');
    });
});