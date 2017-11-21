@extends('user.layout.master')
@section('content')
<section>
<div id="containerlesson" class="container">
 	<!--Lesson list Show -->
      <form action="{{route('start',$word1->id)}}" method="GET">
   	<button class="button_start" >STASRT</button>
      </form>
         @foreach($words as $word)
   		    <div class="item-word">
   		    	<div class="row">{{$word->word}}</div>
   		    	<div class="row">{{$word->phonetic}}</div>
   		    	<div class="row">{{$word->mean}}</div>
   		    </div>
         @endforeach
         
   </div> 
   	<!-------------------------------endList---------------------------------->
   <div class="clear"></div>
</div>
</section>
@endsection
