@extends('user.layout.master')
@section('title')
<title>CreatCousres|Flash-Card</title>
@endsection
@section('content')
	<a class="create-window button" href="#create-box">Create Course</a>
	<div class="create" id="create-box">Create Course
 
 	<a class="close" href="#">
 		<img class="img-close" title="Close Window" alt="Close" src="close.png" />
 	</a>
	<form class="create-content" action="#" method="post">
		<label class="username">
 		<span>Course's Name</span>
 		<input id="username" type="text" autocomplete="on" name="username" placeholder="Username" value=""/>
 		</label>
 		<label class="describe">
 		<span>Describe</span>
 		<input id="describe" type="text" name="describe" value="" />
 		</label>
 		<button class="button submit-button" type="button">Create</button>
 		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/query.min.js"></script>
 	</form>
 	</div>
@endsection