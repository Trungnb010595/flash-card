@extends('admin.layouts.layouts')
@section('content')
    <div class="col-sm-6">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{__('Add User')}}</h4>
            </div>
            <div class="panel-body">
                <form action="{{route('admin.user.add')}}" method="post">
                    {!! csrf_field() !!}

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
                        <label>{{__('Email')}}<span class="text-required"> *</span></label>
                        <input class="form-control" type="email" name="email" value="{{old('email')}}" required >
                        @if($errors->first('email'))
                            <p class = "my_alert">{{$errors->first('email')}}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{__('Password')}}</label>
                        <input class="form-control" type="text" name="password"
                               placeholder="Type for new password here" value="{{old('password')}}" minlength="6">
                        @if($errors->first('password'))
                            <p class = "my_alert">{{$errors->first('password')}}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{__('RePassword')}}</label>
                        <input class="form-control" type="text" name="repassword"
                               placeholder="Type for re password here" value="{{old('repassword')}}" minlength="6">
                        @if($errors->first('repassword'))
                            <p class = "my_alert">{{$errors->first('repassword')}}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{__('Birthday')}}</label>
                        <input class="form-control" type="date" name="birthday" value="{{old('birthday')}}">
                    </div>

                    <div class="form-group">
                        <label>{{__('Phone')}}</label>
                        <input class="form-control" type="number" name="phone" value="{{old('phone')}}">
                    </div>
                    <div class="form-group">
                        <label>{{__('Address')}}</label>
                        <input class="form-control" type="text" name="address" value="{{old('address')}}">
                    </div>
                    <div class="form-group">
                        <label>{{__('Roles')}}</label>
                        <div class="row" style="margin-left: 0px">
                            <select class="select5" name="role_id" style="width: 100px">
                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{$role->id}}" {{old('role_id')==$role->id?'selected':''}}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary min-width-100">{{__('Save')}}</button>
                        <a href="{{route('admin.user.list')}}" class="btn btn-warning min-width-100">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection