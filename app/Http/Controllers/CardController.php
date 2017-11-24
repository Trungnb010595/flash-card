<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Lesson;
use Illuminate\Support\Facades\Session;

class CardController extends Controller
{
    //
    public function getCard($id) {
    	$card = Word::where('id',$id)->get();
    	return view('user.page.flashcard',compact('card',$card));

    }
    public function getNext($id){
        $card = Word::find('id',$id);
        $card1 = Word::find('id',$id+1);
        if (($card1 == NULL)&&($card1->lesson_id != $card->lesson_id))
            return redirect()->back()->with('het_tu','No Words');
        else {
            return view('user.page.flashcard',compact('card',$card1));
        }
    }
    
}
