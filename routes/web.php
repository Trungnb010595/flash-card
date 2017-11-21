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



Route::get('course',[
	'as'=>'trang-chu',
	'uses'=>'CourseController@getCourse'
	])->name('course');
Route::get('lesson/{id}', 'LessonController@getLesson')->name('lesson');
Route::get('words/{id}', 'WordController@getWord')->name('getword');
Route::get('flashcard/{id}', 'FlashcardController@getFlashcard')->name('start');
Route::get('flashcard','FlashcardController@getRemember');
Route::post('flashcard/{id}',[
	'as'=>'remember'
	'uses'=>'FlashcardController@postRemember'])->name('remember');
Route::post('card/{id}','CardController@flipcard')->name('flip');
Route::get('contact','ContactController@getContact')->name('contact');
Route::get('createcourse','CourseController@getCreateCourse');
Route::post('course','CourseController@postCourse')->name('createcourse');

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
