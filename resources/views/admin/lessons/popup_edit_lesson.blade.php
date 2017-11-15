<div id="popup_edit_lesson_{{$lesson->id}}" class="modal fade" role="dialog" style="text-align: left;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{route('admin.lesson.edit')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Lesson</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{$lesson->name}}" required>
                    </div>
                    <div class="form-group">
                        <label>Desc</label>
                        <input type="text" name="desc" class="form-control" value="{{$lesson->desc}}" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="img" class="form-control" placeholder="Anh khoa hoc">
                    </div>
                    <input type="text" name="course_id" value="{{$_GET['course_id']}}" hidden>
                    <input type="text" name="id" value="{{$lesson->id}}" hidden>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Edit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>