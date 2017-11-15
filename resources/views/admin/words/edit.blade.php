@extends('admin.layouts.layouts')
@section('content')
    <div class="col-sm-6">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{$lesson->name}}</h4>
            </div>
            <div class="panel-body">
                <form method="post" action="{{route('admin.word.edit',['id' => $word->id])}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group clearfix">
                        <div class="col-md-6">
                            <input type="text" name="word" class="form-control" value="{{$word->word}}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="mean" class="form-control" value="{{$word->mean}}" placeholder="Nhap nghia" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-6">
                            <input type="text" name="phonetic" class="form-control" value="{{$word->phonetic}}" placeholder="Phien am" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="desc" class="form-control" value="{{$word->desc}}" placeholder="Mo ta" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-6">
                            <input type="text" name="example" class="form-control" value="{{$word->example}}" placeholder="Vi du" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="example_mean" class="form-control" value="{{$word->example_mean}}" placeholder="Nghia vi du" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-6">
                            <input type="text" name="img" class="form-control" placeholder="Chon anh" disabled>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="audio" class="form-control" placeholder="Chon audio" disabled>
                        </div>
                    </div>
                    <input type="text" name="lesson_id" value="{{$lesson->id}}" hidden>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection