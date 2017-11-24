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



//logout
Route::get('/logout','UserController@logout')->name('user.logout');

Route::group(['namespace' => 'Web'], function(){
   Route::get('/', 'HomeController@index')->name('home');

    //login-social
    Route::get('facebook/redirect', 'LoginSocialController@redirectToProviderFB')->name('facebook.login');
    Route::get('facebook/callback', 'LoginSocialController@handleProviderCallbackFB')->name('facebook.callback');

    Route::get('google/redirect', 'LoginSocialController@redirectToProviderGG')->name('google.login');
    Route::get('google/callback', 'LoginSocialController@handleProviderCallbackGG')->name('google.callback');
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