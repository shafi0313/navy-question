@extends('admin.layout.master')
@section('title', 'Generate Question')
@section('content')
@php $m='generateQuestion'; $sm=''; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('admin.exam.index') }}">Question</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Create</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Question</div>
                        </div>
                        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                        {{-- <form action="{{ route('admin.question.store') }}" method="post"> --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exam_id">Exam <span class="t_r">*</span></label>
                                            <input name="exam_id" class="form-control" value="{{ $exam->name }}" readonly>
                                            {{-- <select class="form-control" name="exam_id" id="exam_id">
                                                <option selected value disabled>Select</option>
                                                @foreach ($exams as $exam)
                                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                @endforeach
                                            </select> --}}
                                            @if ($errors->has('exam_id'))
                                                <div class="alert alert-danger">{{ $errors->first('exam_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_id">Subject <span class="t_r">*</span></label>
                                            <input name="subject_id" class="form-control" value="{{ $exam->subject->name }}" readonly>
                                            {{-- <select class="form-control" name="subject_id" id="subject_id">
                                            </select> --}}
                                            @if ($errors->has('subject_id'))
                                                <div class="alert alert-danger">{{ $errors->first('subject_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="chapter_id">Chapter <span class="t_r">*</span></label>
                                            {{-- <select class="form-control" name="chapter_id" id="chapter_id"> --}}
                                            <select class="form-control" name="chapter_id" id="chapter_id">
                                            <option selected value disabled>Select</option>
                                            @foreach ($chapters as $chapter)
                                                <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                            @endforeach
                                            </select>
                                            @if ($errors->has('chapter_id'))
                                                <div class="alert alert-danger">{{ $errors->first('chapter_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr class="bg-danger">
                                    </div>
                                    <style>
                                        .quesType{
                                            font-size: 18px;
                                            border-bottom: 1px solid gray;
                                            margin-bottom: 10px !important;
                                        }
                                        .questionArea {
                                            padding: 0 20px;
                                        }

                                        .question span{
                                            margin-left: 100px;
                                        }
                                        .option{
                                            margin-left: 30px;
                                        }
                                    </style>


                                    <form action="{{ route('admin.generateQuestion.store') }}" method="POST">
                                        @csrf
                                    <div class="questionArea" id="questionArea">
                                    </div>





                                </div>
                            </div>
                            <div class="text-center card-action">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.footer')
</div>
@push('custom_scripts')
<script>
    $('#chapter_id').change(function () {
        $("#questionArea").html('');
        $.ajax({
            url:"{{route('admin.generateQuestion.getQuestion')}}",
            data:{chapterId:$(this).val()},
            method:'get',
            success:res=>{
                if(res.status == 200){
                    var quesData = '';
                    $.each(res.questions,function(i,v){
                        quesData += '<h4 class="question">'
                        quesData += '<input type="hidden" name="exam_id[]" value="'+v.exam_id+'">'
                        quesData += '<label><input type="checkbox" name="question_id[]" class="child" value="'+v.id+'">&nbsp;&nbsp; </label>'+v.ques+'';
                        quesData += '<span style="float:right">'+v.mark+'</span>';
                        quesData += '</h4">';
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
</script>
<script>

    $("#quesType").change(function(){
        const type = $(this).val();
        if(type == "Multiple Choice"){
            $(".quesTypeDiv").show();
        }else{
            $(".quesTypeDiv").hide();
        }
    })

	$(document).ready(function(){
		var i = 1;
		$('.addrow').click(function()
			{i++;
				html ='';
				html +='<tr id="remove_'+i+'" class="post_item">';
	            html +='	<td><input type="text" name="option[]" id="purchase_" class="form-control form-control-sm"/></td>';
	            html +='	<td style="width: 20px"  class="col-md-2"><span class="btn btn-sm btn-danger" onclick="return remove('+i+')"><i class="fa fa-times" aria-hidden="true"></i></span></td>';
	            html +='</tr>';
	            $('#showItem').append(html);
			});
	});
	function remove(id)
	{
		$('#remove_'+id).remove();
		total_price();
    }
</script>
@endpush
@endsection

