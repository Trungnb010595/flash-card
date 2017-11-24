<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\RememberWord;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class FlashcardController extends Controller
{
    //
    public function getFlashcard($id){
    	$card = Word::find($id);
    	$card1 = Word::find($id+1);
    	$card2 = Word::find($id-1);
    	return view('user.page.flashcard',compact('card','card1','card2'));
    }
    public function getRemember(){
    	return view('user.page.flashcard');
    }
    /*public function postRemember($id){
    	$cardrem = Word::find($id);
    	$rem = new RememberWord;
    	$rem->user_id = Auth::user()->id;
    	$rem->word_id = $id;
    	$rem->lesson_id = $word->lesson_id;
    	$rem->status = 1;
    	$rem->save();
    	return redirect()->back();
    }*/
    
}
