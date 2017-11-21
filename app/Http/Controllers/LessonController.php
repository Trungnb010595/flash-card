<?php

namespace App\Http\Controllers;
use App\Lesson;
use App\Word;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class LessonController extends Controller
{
    //
    public function getLesson($id){
    	$lesson = Lesson::where('course_id',$id)->get();
    	return view('user.page.lesson',compact('lesson'));
    }
    
}
