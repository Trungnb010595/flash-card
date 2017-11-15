<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RememberWord extends Model
{
    protected $table = 'remember_words';
    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
    public function lesson(){
    	return $this->belongsTo('App\Lesson','lesson_id','id');
    }
	public function word(){
    	return $this->belongsTo('App\Word','word_id','id');
    }

}
