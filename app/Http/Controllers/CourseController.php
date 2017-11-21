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
    public function getCreateCourse(){
    	return view('user.page.createcourse');
    }
    public function postCourse(Request $req){
    	$this->validate($req,
    		[
    			'name'=>'required|min:1|max:30|',
    			'describe'=>'required',
    		],
    		[
    			'name.required'=>'Enter name',
    			'describe.required'=>'Enter discribe',
    		]);
    	$course = new Course;
    	$course->user_id = 1;
    	$course->name = $req->name;
    	$course->desc = $req->describe;
    	if ($req->share =='no'){
    		$course->share = 0;
    	}
    	$course->save();
    	return redirect()->back()->with('Thanh_cong','Success!');
    }

}
