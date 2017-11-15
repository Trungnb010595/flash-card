@extends('admin.layouts.layouts')
@section('title', 'User')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">{{trans('User List')}}</h4>
        </div>
        <div class="row panel-heading panel-heading-actions">
            <div class="row panel-heading panel-heading-actions">
                <a href="{{route('admin.user.add')}}">
                    <div class="btn btn-primary pull-right">{{trans('Add User')}}</div>
                </a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($users))
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{\Spatie\Permission\Models\Role::find($user->role_id)->name}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->created_at}}</td>
                                    <td>{{$user->updated_at}}</td>
                                    <td>
                                        @if($user->status)
                                            <a href="{{route('admin.user.status', ['status' => 0, 'id' => $user->id])}}"
                                               class="label label-success">{{trans('Enabled')}}</a>
                                        @else
                                            <a href="{{route('admin.user.status', ['status' => 1, 'id' => $user->id])}}"
                                               class="label label-warning">{{trans('Disabled')}}</a>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="table-options">
                                            <li><a href="{{route('admin.user.edit', ['id' => $user->id])}}"><i
                                                            class="fa fa-pencil"></i></a>
                                            </li>
                                            <li><a href="{{route('admin.user.delete', ['id' => $user->id])}}"
                                                   onclick="return confirmDelete()"><i
                                                            class="fa fa-trash fa-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- panel -->
    </div>
@endsection