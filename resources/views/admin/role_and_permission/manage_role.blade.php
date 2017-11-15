@extends('admin.layouts.layouts')
@section('title')
    Manage Role
@endsection
@section('content')
    <div class="col-md-5" style="padding-left: 0px">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{$role_edit?'Edit Role':'Add Role'}}</h4>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{$role_edit?route('admin.role.edit',['id' => $role_edit->id]):route('admin.role.add')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>{{trans('Role Name')}}</label>
                        <input type="text" class="form-control" name="name" value="{{$role_edit?$role_edit->name:''}}">
                    </div>
                    <div class="form-group">
                        <label>{{trans('Role Name view')}}</label>
                        <input type="text" class="form-control" name="desc" value="{{$role_edit?$role_edit->desc:''}}">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" style="min-width: 100px">{{$role_edit?'Save':'Add'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7" style="padding-right: 0px">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">List Role</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover nomargin">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>desc</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $index => $role)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->desc}}</td>
                                <td>{{dateToDDMMYY($role->created_at)}}</td>
                                <td>{{dateToDDMMYY($role->updated_at)}}</td>
                                <td>
                                    <ul class="table-options">
                                        <li><a href="{{route('admin.role.edit',['id'=>$role->id])}}"><i class="fa fa-pencil"></i></a></li>
                                        <li><a href="{{route('admin.role.delete',['id'=>$role->id])}}" onclick="return confirmDelete()"><i class="fa fa-trash"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div>
        </div>
    </div>
@endsection