<?php
/**
 * Created by PhpStorm.
 * User: kaopizadmin
 * Date: 07/11/2017
 * Time: 09:12
 */

namespace App\Http\Controllers;


use App\Cloner;

class BackgroundController
{
    public function cloneCourses(){
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 600);
        $courses = Cloner::getInstance()->cloneCourses();
        return 1;
    }

    public function cloneLessons(){
        $lessons = Cloner::getInstance()->cloneLesssons();
        return $lessons;
    }
    public function cloneWords(){
        $lessons = Cloner::getInstance()->cloneWords();
        return $lessons;
    }
}