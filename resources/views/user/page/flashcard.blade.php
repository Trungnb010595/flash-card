@extends('user.layout.master')
@section('content')
<section>
	<div  class ="container-flashcard">
		<div id="controls"> 
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
					<div class="remembered-container">
					<a href="#" class="fa fa-tags"> Remebered</a>
					</div>
					<div class="example-container">
						<a href="#" class="fa fa-tags"> Example</a>
					</div>
				</div>


			</div>
		</div>
		<div class="clear"></div>
	</div>
</section>
@endsection

