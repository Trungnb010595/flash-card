<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
class CourseController extends Controller
{
    //
    public function getCourse(){
    	$course = Course::all();
    	return view('user.page.course',compact('course',$course));
    }

}
