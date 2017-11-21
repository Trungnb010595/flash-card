@extends('user.layout.master')
@section('content')
	<section>
			<div class="container"
				<div class="row">
					<div class="create_course">
						<button >
							<a href="#" class="fa fa-plus">  Create Course</a>
						</button>
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