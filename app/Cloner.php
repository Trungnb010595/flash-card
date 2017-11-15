<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cloner extends Model
{
    public static function getInstance(){
        return new Cloner();
    }
    public function cloneCourses()
    {
        $baseUrl = "http://minder.vn/api/courses/courses?srcLang=101&limit=0&skip=0";
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 600);


        $html = file_get_contents($baseUrl);

        $courses = json_decode($html)->Courses;
        foreach ($courses as $index => $item){
            $course = new Course();
            $course->user_id = 1;
            $course->name = substr($item->name,0,29);
            $course->desc = substr($item->desc,0,99);
            $course->lesson_quantity = $item->subject;
            $course->word_quantity = $item->word;
            $course->view_quantity = 0;
            $course->share = 1;
            $course->id_clone = $item->id;
            $course->save();
        }
    }

    public function cloneLesssons(){
        $courses = Course::all();

        foreach ($courses as $course){
            $baseUrl = 'http://minder.vn/api/subjects/subjects?id_course='.$course->id_clone;
            ini_set('memory_limit', '1024M');
            ini_set('max_execution_time', '600');
            $html_lessons = file_get_contents($baseUrl);
            $lessons = json_decode($html_lessons)->Subjects;

            foreach ($lessons as $lesson){
                $new_lesson = new Lesson();
                if(preg_replace('/([^\pL\.\ ]+)/u', '', strip_tags(substr($lesson->name,0,29))) == ''){
                    $new_lesson->name = 'Tên bài học';
                }
                else{
                    $new_lesson->name = preg_replace('/([^\pL\.\ ]+)/u', '', strip_tags(substr($lesson->name,0,29)));
                }
                $new_lesson->course_id = $course->id;
                $new_lesson->desc = substr($lesson->name,0,99);
                $new_lesson->img = '123';
                $new_lesson->word_quantity = $lesson->total;
                $new_lesson->id_clone = $lesson->id;
                $new_lesson->save();
            }

        }

        return 1;
    }

    public function cloneWords(){
        $lesssons = Lesson::all();
        foreach ($lesssons as $lessson){
            $baseUrl = 'http://minder.vn/api/words/words?id_subject='.$lessson->id_clone;
            ini_set('memory_limit', '1024M');
            ini_set('max_execution_time', '1800');
            $html = file_get_contents($baseUrl);
            $words = json_decode($html)->Words;

            foreach ($words as $word){
                $new_word = new Word();
                $new_word->lesson_id = $lessson->id;
                $new_word->word = substr($word->word,0,29);
                $new_word->mean = $word->mean;
                $new_word->example = $word->example?$word->example:'not availble';
                $new_word->example_mean = $word->example_mean?$word->example_mean:'not availble';
                if(preg_replace('/([^\pL\.\ ]+)/u', '', strip_tags(substr($word->phonetic,0,49))) == ''){
                    $new_word->phonetic = 'phonetic';
                }
                else{
                    $new_word->phonetic = preg_replace('/([^\pL\.\ ]+)/u', '', strip_tags(substr($word->phonetic,0,49)));
                }
                $new_word->desc = $word->des;
                $new_word->img = 'ff';

                $new_word->save();
            }

        }

        return 1;
    }
}
