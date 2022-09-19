@extends('admin.layout.master')
@section('title', 'Generate Question')
@section('content')
@php $m='generateQuestion'; $sm=''; $ssm='';  $delete='delete'; $edit='edit'; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Question</li>
                </ul>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form action="{{ route('admin.generateQuestion.addQues') }}" method="POST" id="">
                        @csrf
                        <input type="hidden" name="subject_id" value="{{$chapters->first()->first()->question->subject_id}}">
                        <input type="hidden" name="ques_info_id" value="{{$chapters->first()->first()->ques_info_id}}" id="ques_info_id">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4>{{ $quesInfo->exam->name}}</h4>
                                    <h4>{{ $quesInfo->subject->name}}</h4>
                                    <hr>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_id">Exam <span class="t_r">*</span></label>
                                        <select class="form-control select2" name="exam_id" id="exam_id" required>
                                            <option selected value disabled>Select</option>
                                            @foreach ($exams as $exam)
                                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('exam_id'))
                                            <div class="alert alert-danger">{{ $errors->first('exam_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject_id">Subject <span class="t_r">*</span></label>
                                        <select class="form-control select2" name="subject_id" id="subject_id" required></select>
                                        @if ($errors->has('subject_id'))
                                            <div class="alert alert-danger">{{ $errors->first('subject_id') }}</div>
                                        @endif
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="chapter_id">Chapters <span class="t_r">*</span></label>
                                        <select class="form-control select2" name="chapter_id" id="chapter_id">
                                            <option selected value disabled>Select</option>
                                            @foreach ($mainChapters as $mainChapter)
                                            <option value="{{ $mainChapter->id }}">{{ $mainChapter->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('chapter_id'))
                                            <div class="alert alert-danger">{{ $errors->first('chapter_id') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Question Type <span class="t_r">*</span></label>
                                        <select class="form-control select2" name="type" id="quesType" required>
                                            <option selected value disabled>Select</option>
                                            <option value="multiple_choice">Multiple Choice</option>
                                            <option value="short_question">Short Question</option>
                                            <option value="long_question">Long Question</option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <div class="alert alert-danger">{{ $errors->first('type') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3 class="text-primary">Question</h3>
                                <table class="table table-striped table-bordered table-hover w-100" >
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Type</th>
                                            <th>Marks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="questionArea" id="questionArea"></tbody>
                                    <tbody class="questionArea" id="question"></tbody>
                                </table>
                            </div>
                            <div class="col-md-12 text-center card-action">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
             </div>

            <form action="{{ route('admin.generateQuestion.complete') }}" method="POST">
                @csrf
                <input type="hidden" name="quesInfoId" value="{{$quesInfoId}}">
                @include('include.question_paper')
                <div class="col-md-12 text-center card-action">
                    <button type="submit" class="btn btn-primary">Generate Question</button>
                </div>
            </form>

        </div>
    </div>
 @include('include.footer')
</div>
<style>
    .ptag p {
        display: inline-block;
    }
</style>
@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
    <script>
        $('#chapter_id').change(function () {
            $("#quesType").val(null).trigger('change');
        });

        $('#exam_id').change(function () {
        $.ajax({
            url:'{{route("admin.global.getSubject")}}',
            method:'get',
            data:{
                exam_id : $(this).val(),
            },
            success: function (res) {
                if (res.status == 'success') {
                    $('#subject_id').html(res.html);
                }
            }
        });
     })

     $('#subject_id').change(function () {
        $.ajax({
            url:"{{route('admin.question.getChapter')}}",
            data:{subjectId:$(this).val()},
            method:'get',
            success:res=>{
                let opt = '<option disabled selected>- -</option>';
                if(res.status == 200){
                $.each(res.chapters,function(i,v){
                    opt += '<option value="'+v.id+'">'+v.name+'</option>';
                });
                $("#chapter_id").html(opt);
                }else{
                    alert('No chapter found')
                }
            },
            error:err=>{
                alert('No chapter found')
            }
        });
    });


        $('#quesType').change(function () {
            $("#questionArea").html('');
            let chapterId = $('#chapter_id').find(":selected").val();
            let quesType = $(this).val();
            $.ajax({
                url:"{{route('admin.generateQuestion.getQuestion')}}",
                data:{chapterId:chapterId, quesType:quesType},
                method:'get',
                success:res=>{
                    if(res.status == 200){
                        let quesData = '';
                        $.each(res.questions,function(i,v){
                            let str = v.type;
                            let id = v.id;
                            let url = '{{ route("admin.question.edit", ":id") }}';
                            url = url.replace(':id', id);
                            quesData += '<tr>'
                            quesData += '<td class="ptag"><input type="checkbox" name="question_id[]" value="'+v.id+'">&nbsp;&nbsp; '+v.ques+'</td>'
                            quesData += '<td>'+ str.replace(/_/g, ' ')+ '</td>'
                            quesData += '<td>'+v.mark+'</td>'
                            quesData += '<td>'
                            quesData +=     '<div class="form-button-action">'
                            quesData +=         '<a href='+url+' data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">Edit</a>'
                            quesData +=     '</div>'
                            quesData += '</td>'
                            quesData += '</tr>'
                        });
                        $("#questionArea").append(quesData);
                    }else{
                        alert('No question found')
                    }
                },
                error:err=>{
                    alert('No question found')
                }
            });
        });



    // $('#quesType').change(function () {
    //         $("#questionArea").html('');
    //         let chapterId = $('#chapter_id').find(":selected").val();
    //         let quesType = $(this).val();
    //         $.ajax({
    //             url:"{{route('admin.generateQuestion.getQuestion')}}",
    //             data:{chapterId:chapterId, quesType:quesType},
    //             method:'get',
    //             success:res=>{
    //                 if(res.status == 200){
    //                     question()
    //                 }else{
    //                     alert('No question found')
    //                 }
    //             },
    //             error:err=>{
    //                 alert('No question found')
    //             }
    //         });
    //     });



    // function clear() {
    //     $("#questionArea").html('');
    //     $("#ques").val('');
    //     $("#mark").val('');
    //     $("#option").val('');
    //     $("#image").val('');
    //     CKEDITOR.instances.ques.setData('')
    // }

    // function question(){
    //     $.ajax({
    //         url:'{{route("admin.question.read")}}',
    //         method:'get',
    //         data:{
    //             subject_id : $('#subject_id').val(),
    //             chapter_id : $('#chapter_id').val(),
    //             type : $('#quesType').val(),
    //         },
    //         success: function (res) {
    //             if (res.status == 'success') {
    //                 $('#question').html(res.html);
    //             }
    //         }
    //     });
    // }
    </script>
@endpush
@endsection

