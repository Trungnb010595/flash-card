<?php
/**
 * Created by PhpStorm.
 * User: kaopizadmin
 * Date: 10/11/2017
 * Time: 15:49
 */

namespace App\Http\Controllers\Admin;


use App\Course;
use App\Lesson;
use App\Word;
use Illuminate\Http\Request;

class LessonController extends AdminBaseController
{
    public function index(Request $request){
        $course_id = $request->get('course_id');
        $lessons = Lesson::where('course_id',$course_id)->orderBy('seq','asc')->get();
        $lesson_old_id = '';
        if ($request->has('lesson_old_id')){
            $lesson_old_id = $request->get('lesson_old_id');
        }

        return $this->render('admin.lessons.list',['lessons' => $lessons, 'lesson_old_id' => $lesson_old_id]);
    }

    public function add(Request $request){
        $lesson = new Lesson();
        $lesson->name = $request->get('name');
        $lesson->course_id = $request->get('course_id');
        $lesson->desc = $request->get('desc');
        $lesson->img = /*$request->get('img')*/'img';
        $lesson->save();

        dflash('Thêm bài học thành công!', 'success');
        return back();
    }

    public function edit(Request $request){
        $id = $request->get('id');
        $lesson = Lesson::find($id);

        $lesson->name = $request->get('name');
        $lesson->desc = $request->get('desc');

        $lesson->save();
        dflash('Sửa bài học thành công!', 'success');
        return back();

    }

    public function delete(Request $request){
        dflash('Hệ thống chưa hỗ trợ tính năng này!!', 'warning');
        return back();
    }
}