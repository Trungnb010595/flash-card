<div id="popup_add_course" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{route('admin.course.add')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Course</h4>
                </div>
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>