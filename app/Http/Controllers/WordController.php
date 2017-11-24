<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;

class WordController extends Controller
{
    //
    public function getWord( $id){
    	$word1 = Word::where('lesson_id',$id)->first();
    	$words = Word::where('lesson_id',$id)->get();
    	return view('user.page.word',compact('words','word1'));
    }
}
