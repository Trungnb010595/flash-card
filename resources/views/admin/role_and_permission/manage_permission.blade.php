@extends('admin.layouts.layouts')
@section('title')
    Manage Permission
@endsection
@section('content')
    <div class="col-md-5" style="padding-left: 0px">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">Add Permission</h4>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{$permission_edit?route('admin.permission.edit-name-view',['id'=>$_REQUEST['id']]):route('admin.permission.add')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>{{trans('Permission Name')}}</label>
                        <input type="text" class="form-control" name="name" value="{{$permission_edit?$permission_edit->name:''}}" {{$permission_edit?'disabled':''}} placeholder="Is route name">
                    </div>
                    <div class="form-group">
                        <label>{{trans('Desc')}}</label>
                        <input type="text" class="form-control" name="desc" value="{{$permission_edit?$permission_edit->desc:''}}">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" style="min-width: 100px">{{$permission_edit?'Save':'Add'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7" style="padding-right: 0px">
        <div class="panel">
            <div class="panel-heading clearfix">
                <label class="panel-title">List Role</label>
                <form method="post" action="{{route('admin.permission.sort')}}" enctype="multipart/form-data" class="pull-right">
                    {{csrf_field()}}
                    {{--<a class="pull-right" style="display: inline-block">
                        <label class="btn btn-primary text-uppercase">Sort Channel</label>
                    </a>--}}
                    <input type="hidden" name="arr_sort" value="">
                    <div class="form-group" style="display: inline-block">
                        <button type="submit" class="save_sort btn btn-primary text-uppercase" style="min-width: 100px">Save Sort</button>
                    </div>
                </form>
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
                        <tbody id="sortable">
                        @foreach($permissions as $index => $permission)
                            <tr class="ui-state-default">
                                <td>
                                    {{$index+1}}
                                    <input type="hidden" value="{{$permission->id}}">
                                </td>
                                <td>{{$permission->name}}</td>
                                <td>{{$permission->desc}}</td>
                                <td>{{dateToDDMMYY($permission->created_at)}}</td>
                                <td>{{dateToDDMMYY($permission->updated_at)}}</td>
                                <td>
                                    <ul class="table-options">
                                        <li><a href="{{route('admin.permission.edit-name-view',['id'=>$permission->id])}}"><i class="fa fa-pencil"></i></a></li>
                                        <li><a href="{{route('admin.permission.delete',['id'=>$permission->id])}}" onclick="return confirmDelete()"><i class="fa fa-trash"></i></a></li>
                                    </ul>
                                </td>-
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $( "#sortable" ).sortable();
            $('.save_sort').on('click',function () {
                var arr = [];
                var k = 1;
                $('#sortable tr.ui-state-default').each(function () {
                    var obj = {'id': '', 'seq': ''};
                    obj.id = $(this).find('input').val();
                    obj.seq = k;
                    k++;
                    arr.push(obj);
                });
                $('input[name=arr_sort]').attr('value',JSON.stringify(arr));
            })
        });
    </script>
@endsection