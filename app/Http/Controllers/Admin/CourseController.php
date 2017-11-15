<?php
/**
 * Created by PhpStorm.
 * User: kaopizadmin
 * Date: 10/11/2017
 * Time: 11:41
 */

namespace App\Http\Controllers\Admin;


use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends AdminBaseController
{
    public function index(){
        $courses = Course::orderBy('seq','asc')->get();
        return $this->render('admin.courses.list',['courses' => $courses]);
    }

    public function add(Request $request){
        if ($request->isMethod('GET')){
            return $this->render('admin.courses.add');
        }
        else{
            $course = new Course();
            $course->name = $request->get('name');
            $course->desc = $request->get('desc');
            $course->user_id = Auth::user()->id;
            $course->save();

            dflash('Thêm khóa học thành công!','success');
            return redirect()->route('admin.course.list');
        }
    }

    public function edit(Request $request){
        $id = $request->get('id');
        $course = Course::find($id);
        if(!$course){
            dflash('Không tìm thấy khóa học','danger');
            return back();
        }
        else {
            if($request->isMethod('GET')){
                return $this->render('admin.courses.edit',['course' => $course]);
            }
            else{
                $course->name = $request->get('name');
                $course->desc = $request->get('desc');
                if($request->get('share')  == 'on'){
                    $course->name = 1;
                }
                else{
                    $course->name = 0;
                }

                $course->save();
                dflash('Sửa khóa học thành công!','success');
                return redirect()->route('admin.course.list');
            }

        }
    }

    public function delete(Request $request){
        $id = $request->get('id');
        $course = Course::find('id');
        if($course){
            $course->delete(); //de y vi con phai xoa lesson vs tu nua
        }
    }

}