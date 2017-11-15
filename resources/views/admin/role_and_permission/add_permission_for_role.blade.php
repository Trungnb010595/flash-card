@extends('admin.layouts.layouts')
@section('title')
    Add Permisstion For Role
@endsection
@section('css')
    <style>
        ul.list_permission li{
            border-bottom: 1px solid #ddd;
            height: 40px;
            line-height: 40px;
        }
        ul.list_permission{
            max-height: 500px;
            overflow: auto;
        }
    </style>
@endsection
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">Add Permission For Role</h4>
        </div>
        <div class="panel-body">
            <div class="col-xs-4">
                <div class="form-group">
                    <h5>Role*:</h5>
                    <form class="form_select_role" method="GET" action="{{route('admin.add-permission-for-role')}}"
                          enctype="multipart/form-data">
                        <input type="hidden" name="role_id" class="input_role_id" value="1">
                        <select class="select5 select_role" style="min-width: 100px;" onchange="selectRole()">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" {{($_REQUEST['role_id']==$role->id)?'selected':''}}>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <form method="POST" action="{{route('admin.add-permission-for-role',['role_id'=>$_REQUEST['role_id']])}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="arr_checkbox" class="arr_checkbox" value="">
                    <div class="form-group">
                        <ul class="list-unstyled text-left list_permission">
                            <li>
                                <div class="col-xs-9">
                                    <h5>Permissions</h5>
                                </div>
                                <div class="col-xs-3">
                                    <h5>Status</h5>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            @foreach($permissions as $permission)
                                <li class="item">
                                    <div class="col-xs-9">
                                        <span>{{$permission->desc}}</span>
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="ckbox ckbox-inline ckbox-info">
                                            <input type="checkbox" per_name="{{$permission->name}}" per_id="{{$permission->id}}"
                                                   @foreach($role_has_permissions as $role_has_permission)
                                                   @if($permission->id == $role_has_permission->permission_id)
                                                   checked
                                                    @endif
                                                    @endforeach
                                            >
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn_save" style="min-width: 100px">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function selectRole() {
            $role_id = $('.select_role option:selected').val();
            $('input.input_role_id').val($role_id);
            console.log($role_id);
            $('form.form_select_role').submit();
        }
        $(document).ready(function () {
            $('.btn_save').on('click',function () {
                var arr = [];
                $('ul.list_permission li.item').each(function () {
                    var status = $(this).find('input[type=checkbox]').is(':checked');
                    var per_name = $(this).find('input[type=checkbox]').attr('per_name');
                    var per_id = $(this).find('input[type=checkbox]').attr('per_id');
                    var obj = {};
                    obj.per_name = per_name;
                    obj.per_id = per_id;
                    if(status == true){
                        obj.status = 1;
                    }
                    else {
                        obj.status = 0;
                    }
                    arr.push(obj);
                })
                console.log(arr);
                $('input.arr_checkbox').val(JSON.stringify(arr));
            })
        })
    </script>
@endsection