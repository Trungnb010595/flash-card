<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = 'words';
    public function lesson(){
    	return $this->belongsTo('App\Lesson','lesson_id','id');
    }
}
