@extends('admin.layouts.layouts')
@section('title', 'List Lesson')
@section('content')

    <div class="col-md-5">
        <div class="panel">
            <div class="panel-heading">
                <h4>List lesson</h4>
            </div>
            <div class="row panel-heading panel-heading-actions">
                <div class="btn btn-primary pull-right" data-toggle="modal" data-target="#popup_add_lesson">{{trans('Add Lesson')}}</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover tb_lessons">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Desc</th>
                            <th>Img</th>
                            <th>Words</th>
                            <th>Updated_at</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($lessons))
                            @foreach($lessons as $index => $lesson)
                                <tr class="lesson_id_{{$lesson->id}}">
                                    <td>{{$index + 1}}</td>
                                    <td class="td_name_lesson">{{$lesson->name}}</td>
                                    <td class="td_course">{{\App\Course::find($lesson->course_id)->name}}</td>
                                    <td>{{$lesson->desc}}</td>
                                    <td>{{$lesson->img}}</td>
                                    <td class="word_quantity" data-id="{{$lesson->id}}" style="cursor: pointer; color: #3456b1">
                                        {{$lesson->word_quantity}}
                                    </td>
                                    <td>{{$lesson->updated_at}}</td>
                                    <td>
                                        <ul class="table-options">
                                            <li>
                                                <div class="btn btn-primary" data-toggle="modal" data-target="#popup_edit_lesson_{{$lesson->id}}" style="cursor: pointer; padding: 2px 5px">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                @include('admin.lessons.popup_edit_lesson')
                                            </li>
                                            <li>
                                                <a href="{{route('admin.lesson.delete', ['id' => $lesson->id])}}"
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
                {{--{{ $lessons->appends(request()->input())->links() }}--}}
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="title_list_word">List Word</h4>
            </div>
            <div class="row panel-heading panel-heading-actions">
                <a href="{{route('admin.word.add')}}" class="pull-right btn_add_word" style="display: inline-block">
                    <label class="btn btn-primary pull-right" >Add word</label>
                </a>
                {{--<div class="btn btn-primary pull-right" data-toggle="modal" data-target="#popup_add_word">{{trans('Add Word')}}</div>--}}
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover tb_words">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>word</th>
                            <th>lesson</th>
                            <th>mean</th>
                            <th>phonetic</th>
                            <th>img</th>
                            <th>Updated_at</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        {{--@if(isset($words))
                            @foreach($words as $index => $word)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$word->$word}}</td>
                                    <td>{{\App\Lesson::find($word->lesson_id)->name}}</td>
                                    <td>{{$word->mean}}</td>
                                    <td>{{$word->phonetic}}</td>
                                    <td>{{$word->img}}</td>
                                    <td>{{$word->updated_at}}</td>
                                    <td>
                                        <ul class="table-options">
                                            <li>
                                                <a href="{{route('admin.lesson.edit', ['id' => $word->id])}}"><i
                                                            class="fa fa-pencil"></i></a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin.lesson.delete', ['id' => $word->id])}}"
                                                   onclick="return confirmDelete()"><i
                                                            class="fa fa-trash fa-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @endif--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.lessons.popup_add_lesson');
    <table class="tb_word_clone">
        <tr class="">
            <td class="td_index">{{--{{$index + 1}}--}}</td>
            <td class="td_word">{{--{{$word->$word}}--}}</td>
            <td class="td_lesson">{{--{{\App\Lesson::find($word->lesson_id)->name}}--}}</td>
            <td class="td_mean">{{--{{$word->mean}}--}}</td>
            <td class="td_phonetic">{{--{{$word->phonetic}}--}}</td>
            <td class="td_img">{{--{{$word->img}}--}}</td>
            <td class="td_updated_at">{{--{{$word->updated_at}}--}}</td>
            <td class="td_optional">
                <ul class="table-options">
                    <li>
                        <a href=""><i
                                    class="fa fa-pencil"></i></a>
                    </li>
                    <li>
                        <a href="{{route('admin.lesson.delete')}}"
                           onclick="return confirmDelete()"><i
                                    class="fa fa-trash fa-delete"></i></a>
                    </li>
                </ul>
            </td>
        </tr>
    </table>

    <style>
        .tb_word_clone{
            display: none;
        }
        table.tb_lessons tbody tr.active td{
            background-color: #D3DCE3;
        }
    </style>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            //Check active lesson
            var lesson_old_id = "{{$lesson_old_id}}";
            if(lesson_old_id){
                var lesson_active = '.lesson_id_'+lesson_old_id;
                $(lesson_active).addClass('active');
                $('.title_list_word').text("{{\App\Lesson::find($lesson_old_id)?\App\Lesson::find($lesson_old_id)->name:''}}");

                $(".btn_add_word").attr('href',$(".btn_add_word").attr('href')+'?lesson_id='+lesson_old_id);
                bind_word(lesson_old_id,"{{\App\Lesson::find($lesson_old_id)?\App\Lesson::find($lesson_old_id)->course->name:''}}",1);
            }
            //Load word
            function bind_word(lesson_id, course_name, page) {
                var url_edit_word = "{{route('admin.word.edit')}}";
                var url_delete_word = "{{route('admin.word.delete')}}";
                $.ajax({
                    url : "{{route('admin.word.ajax-get-words')}}" + "?page=" + page,
                    type : "get",
                    dataType : "json",
                    data : {
                        lesson_id : lesson_id
                    },
                    success : function (result) {
                        $('.tb_words tbody').empty();
                        /*var data = result.data;*/
                        var data = result;
                        for (var i = 0; i < data.length; i++){
                            var item = $('.tb_word_clone').clone();
                            item.removeClass('tb_word_clone');
                            item.find('td.td_index').text(i+1);
                            item.find('td.td_word').text(data[i].word);
                            item.find('td.td_lesson').text(course_name);
                            item.find('td.td_mean').text(data[i].mean);
                            item.find('td.td_phonetic').text(data[i].phonetic);
                            item.find('td.td_img').text(data[i].img);
                            item.find('td.td_updated_at').text(data[i].updated_at);
                            item.find('td.td_optional ul li:nth-child(1) a').attr('href',url_edit_word + '?id=' + data[i].id);
                            item.find('td.td_optional ul li:nth-child(2) a').attr('href',url_delete_word + '?id=' + data[i].id);
                            $('.tb_words tbody').append(item.find('tr'));
                        }
                    },
                    error: function(req, err){
                        console.log('my message: ' + err);
                    }
                })
            }

            //On click view words
            $('.tb_lessons tbody td.word_quantity').on('click',function () {
                $('.tb_lessons tbody tr').each(function () {
                    $(this).removeClass('active');
                });
                $(this).parents('tr').addClass('active');

                var lesson_id = $(this).attr('data-id');
                var course_name = $(this).siblings('.td_course').text();

                $('.title_list_word').text($(this).siblings('.td_name_lesson').text());

                $(".btn_add_word").attr('href',$(".btn_add_word").attr('href')+'?lesson_id='+lesson_id);
                bind_word(lesson_id,course_name,1);
            })

        });
    </script>
@endsection