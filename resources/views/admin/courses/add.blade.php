@extends('admin.layouts.layouts')
@section('content')
    <div class="col-sm-6">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{__('Add Course')}}</h4>
            </div>
            <div class="panel-body">
                <form action="{{route('admin.course.add')}}" method="post">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label>{{__('Ngôn ngữ')}}</label>
                        <div class="row" style="margin-left: 0px">
                            <select class="select5" name="role_id" style="width: 100px">
                                <option>English</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{__('Name')}} <span class="text-required"> *</span></label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="name" value="{{old('name')}}" required>
                                @if($errors->first('name'))
                                    <p class = "my_alert">{{$errors->first('name')}}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{__('Description')}} <span class="text-required"> *</span></label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="desc" value="{{old('desc')}}" required>
                                @if($errors->first('desc'))
                                    <p class = "my_alert">{{$errors->first('desc')}}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary min-width-100">{{__('Add')}}</button>
                        <a href="{{route('admin.user.list')}}" class="btn btn-warning min-width-100">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection