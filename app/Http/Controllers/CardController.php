<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;

class CardController extends Controller
{
    //
    public function getCard($id) {
    	$card = Word::where('id',$id)->get();
    	return view('user.page.flashcard',compact('card',$card));

    }
    /*public function flipcard($current){
    	if ($this->current == 0){
    		$this->current ++;
    	}
    	else{
  			$this->current =0;
    	}
    	return view('user.page.flashcard',compact('current',$current)); 
*/
    }
}
