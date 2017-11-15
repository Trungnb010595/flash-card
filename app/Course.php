<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    public function lesson(){
    	return $this->hasMany('App\Lesson','course_id','id');

    }
    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
}
