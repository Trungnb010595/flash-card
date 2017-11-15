@extends('admin.layouts.layouts')
@section('title', 'Courses')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">{{trans('List Course')}}</h4>
        </div>
        <div class="row panel-heading panel-heading-actions">
            <div class="row panel-heading panel-heading-actions">
                <div class="btn btn-primary pull-right" data-toggle="modal" data-target="#popup_add_course">{{trans('Add Course')}}</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>User</th>
                            <th>Desc</th>
                            <th>Status</th>
                            <th>Lessons</th>
                            <th>Words</th>
                            <th>Views</th>
                            <th>Share</th>
                            <th>Updated_at</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($courses))
                            @foreach($courses as $index => $course)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$course->name}}</td>
                                    <td>{{\App\User::find($course->user_id)->name}}</td>
                                    <td>{{$course->desc}}</td>
                                    <td>
                                        <label class="ckbox ckbox-inline ckbox-info">
                                            <input type="checkbox" {{$course->share?'checked':''}}><span></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.lesson.list',['course_id' => $course->id])}}">
                                            {{$course->lesson_quantity}} Edit
                                        </a>
                                    </td>
                                    <td>{{$course->word_quantity}}</td>
                                    <td>{{$course->view_quantity}}</td>
                                    <td>{{$course->share}}</td>
                                    <td>{{$course->updated_at}}</td>
                                    <td>
                                        <ul class="table-options">
                                            <li><a href="{{route('admin.course.edit', ['id' => $course->id])}}"><i
                                                            class="fa fa-pencil"></i></a>
                                            </li>
                                            <li><a href="{{route('admin.course.delete', ['id' => $course->id])}}"
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
                {{--{{ $courses->links() }}--}}
            </div>
        </div><!-- panel -->
    </div>
    @include('admin.courses.popup_add_course')
@endsection