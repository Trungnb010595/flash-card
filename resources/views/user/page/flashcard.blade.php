@extends('user.layout.master')
@section('title')
<title>Card|Flash-Card</title>
@endsection
@section('content')
<section>
	<div  class ="container-flashcard">
		<div id="controls"> 
			<h2 style="text-align: center;">Control</h2>
			<div class="row">
				<a href="#">Detail</a>
			</div>
			<div class="row">
				<a href="#">Game</a>
			</div>
			<div class="row">
				<a href="#">Report</a>
			</div>
		</div>
		<div id="flashcard">
			<div class="container">	
			<div class="flash-card">
  				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							{{$card->word}}
						</div>
						<div class="back">
							<div class="row">[{{$card->phonetic}}]</div>
							<div class="row">{{$card->mean}}</div>
						</div>
					</div>
				</div>
 			 </div>
 			 	<div>
					<button class="fa fa-pencil"></button>
				</div>
				<div class="flash-card-under">
					<form action="#" method="post">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="remember-container">
					<button id ="remeber" class="fa fa-tags" type="submit"> Remebered</button>
					</div>
					</form>
					<div class="example-container">
						<a href="#" class="fa fa-tags"> Example</a>
					</div>
					@if( $card->lesson_id == $card2->lesson_id)
					<div class="undo-container">
						<a href="{{route('start',$card2->id)}}" class="fa fa-undo"> Prev</a>
					</div>
					@endif
					@if ($card->lesson_id == $card1->lesson_id)
					<div class="next-container">
						<a href="{{route('start',$card1->id)}}" class="fa fa-next"> Next</a>
					</div>
					@endif
					
				</div>


			</div>
		</div>
		<div class="clear"></div>
	</div>
</section>
@endsection

