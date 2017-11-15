<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lessons';
    public function course(){
    	return $this->belongsTo('App\Course','course_id','id');
    }
    public function word(){
    	return $this->hasMany('App\Word','lesson_id','id');
    }
    public function rememberword(){
        return $this->hasMany('App\RememberWord','lesson_id','id');
    }
    
}
