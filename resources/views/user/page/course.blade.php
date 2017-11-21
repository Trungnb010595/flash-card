@extends('user.layout.master')
@section('title')
<title>Course|Flash-Card</title>
@endsection
@section('content')
	<section>
			<div class="container"
				<div class="row">
					<div class="create_course">
							<a class="create-window button" href="#create-box">Create Course</a>
							<div class="create" id="create-box">Create Course
 
 							<a class="close" href="#">
 								<img class="img-close" title="Close Window" alt="Close" src="close.png" />
 							</a>
 							@if(count($errors)>0)
                        		@foreach($errors->all() as $err)
                            		<div class="alert alert-warning text-center" role="alert">{{$err}}</div>
                        		@endforeach
                    		@endif
                    		@if(Session::has('thanh_cong'))
                        		<div class="alert alert-warning text-center" role="alert"> {{Session::get('thanh_cong')}}</div>
                    		@endif
							<form class="create-content" action="{{route('createcourse')}}" method="post">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<label class="username">
 								<span>Course's Name</span>
 								<input id="username" type="text" autocomplete="on" name="name" placeholder="Coursename" />
 								</label>
 								<label class="describe">
 								<span>Describe</span>
 								<input id="describe" type="text" name="describe" placeholder="Describe" />
 								</label>
 								<label>
 									<select name="share">
 										<option value="yes">Share</option>
 										<option value="no">No share</option>
 									</select>
 								</label>
 								<button class="button submit-button" type="submit">Create</button>
 								<script type="text/javascript" src="{{asset('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/query.min.js')}}"></script>
 							</form>
 							</div>
					</div>
					<div class="col-sm-3">
						<div class="left-sidebar">
							<h2>Over view</h2>
							<div class="panel-group category-products" id="accordian"><!--category-productsr-->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordian" href="#japanese">
												
												Japanese(0<!-- O day ghi quantity_course-->)
											</a>
										</h4>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordian" href="#english">
												
												English(0<!-- O day ghi quantity_course-->)
											</a>
										</h4>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordian" href="#korean">
												
												Korean(0<!-- O day ghi quantity_course-->)
											</a>
										</h4>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordian" href="#chinese">
												
												Chinese(0<!-- O day ghi quantity_course-->)
											</a>
										</h4>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordian" href="#yourcourse">
												
												Your Courses(0<!-- O day ghi quantity_course-->)
											</a>
										</h4>
									</div>
								</div>
								
								
							</div><!--/category-course-->
						
						
						</div>
					</div>
					
					<div class="col-sm-9 padding-right">
						<div class="features_items"><!--Course-list-->
							<h2 class="title text-center">Courses</h2>
							<!--<h2 class="title text-center">JAPANESE(0)</h2> -->
							<div>
								@foreach($course as $course)
								@if ($course->share ==1)
								<div class="col-sm-4">
									<div class="product-image-wrapper">
										<div class="single-products">
												<div class="productinfo text-center">
													<a href="{{route('lesson',$course->id)}}">
														<img src="image/japanese.jpg" alt="" />
													</a>
													<p>{{$course->name}}</p>
												</div>
										</div>
										<div >
											<ul class="nav nav-pills nav-justified">
												<li><a href="#"><span>L({{$course->lesson_quantity}})</span></a></li>
												<li><a href="#"><span>W({{$course->word_quantity}})</span></a></li>
											</ul>
										</div>
										
									</div>
								</div>
								@endif
								@endforeach
								<!--
								<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
											<div class="productinfo text-center">
												<img src="image/english.jpg" alt="" />
												<p>Course_name</p>
											</div>
									</div>
									<div >
										<ul class="nav nav-pills nav-justified">
											<li><a href="#"><span>L(0)</span></a></li>
											<li><a href="#"><span>W(0)</span></a></li>
										</ul>
									</div>
									
								</div>
								
								</div>

								<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
											<div class="productinfo text-center">
												<img src="image/japanese.jpg" alt="" />
												<p>Course_name</p>
											</div>
									</div>
									<div >
										<ul class="nav nav-pills nav-justified">
											<li><a href="#"><span>L(0)</span></a></li>
											<li><a href="#"><span>W(0)</span></a></li>
										</ul>
									</div>
									
								</div>
								
								</div>
								-->
							</div>
							
						</div>
						<!--
							<h2 class="title text-center">ENGLISH(0)</h2> -->
					</div><!--/category-tab-->
				</div>
			</div>
	</section>
@endsection