@extends('user.layout.master')
@section('title')
<title>LessonFlash-Card</title>
@endsection
@section('content')
<section>
<div id="containerlesson" class="container">
 	<!--Lesson list Show -->
   	<div id="lesson_list" class="auto">
   		<div class="search">
			<form class="form_search_khoahoc">
				<input type="text" name="lesson_search" value="Search">
			</form>
   		</div>
         @foreach($lesson as $lesson)
   		<div class="item-lesson" >
   			<div >
   				<img>
   			</div> 
   			<div class="item-lesson-name">
				  <a href="{{route('getword',$lesson->id)}}">{{$lesson->name}}</a>			
   			</div>
   			<div class="item-lesson-quantity">
   			{{$lesson->word_quantity}} words
   			</div>
   		</div>
         @endforeach
   </div>   
   	<!-------------------------------endList---------------------------------->
   <div class="clear"></div>
</div>
</section>
@endsection
