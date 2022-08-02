@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
@php $m='question'; $sm=''; $ssm=''; @endphp

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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Show Questions</h4>
                                <a href="{{ route('admin.question.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject_id">Subject <span class="t_r">*</span></label>
                                        <select class="form-control select2" name="subject_id" id="subject_id">
                                            <option selected value disabled>Select</option>
                                            @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('subject_id'))
                                            <div class="alert alert-danger">{{ $errors->first('subject_id') }}</div>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="chapter_id">Chapter <span class="t_r">*</span></label>
                                        <select class="form-control select2" name="chapter_id" id="chapter_id">
                                        </select>
                                        @if ($errors->has('chapter_id'))
                                            <div class="alert alert-danger">{{ $errors->first('chapter_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Question Type <span class="t_r">*</span></label>
                                        <select class="form-control" name="type" id="quesType" required>
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
                                <div class="col-md-12">
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
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 @include('include.footer')
</div>

@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
    <script>
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


        $("#subject_id, #chapter_id").change(function(){
            $('#quesType').val('')
            $('#questionArea').html('');
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
                        // toast('error', 'No Codes found')
                    }
                },
                error:err=>{
                    alert('No chapter found')
                    // toast('error', 'No Codes found')
                }
            });
        });

        $('#quesType').change(function () {
            question()
        });
        function question(){
            $.ajax({
                url:'{{route("admin.question.read")}}',
                method:'get',
                data:{
                    subject_id : $('#subject_id').val(),
                    chapter_id : $('#chapter_id').val(),
                    type : $('#quesType').val(),
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#questionArea').html(res.html);
                    }
                }
            });
        }
    </script>
@endpush
@endsection

