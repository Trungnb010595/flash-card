<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;

class FlashcardController extends Controller
{
    //
    public function getFlashcard($id){
    	$card = Word::find($id);
    	return view('user.page.flashcard',compact('card'));
    }
}
