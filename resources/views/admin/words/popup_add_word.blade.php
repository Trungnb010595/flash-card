<div id="popup_add_word" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{route('admin.word.add')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Lesson</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group clearfix">
                        <div class="col-md-6">
                            <input type="text" name="word" class="form-control" placeholder="Nhap tu" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="mean" class="form-control" placeholder="Nhap nghia" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-6">
                            <input type="text" name="phonetic" class="form-control" placeholder="Phien am" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="desc" class="form-control" placeholder="Mo ta" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-6">
                            <input type="text" name="example" class="form-control" placeholder="Vi du" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="example_mean" class="form-control" placeholder="Nghia vi du" required>
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
                    <input type="text" name="lesson_id" value="" hidden>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>