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
                        <form action="{{ route('admin.generateQuestion.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exam_id">Exam <span class="t_r">*</span></label>
                                            <select class="form-control" name="exam_id" id="exam_id">
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
                                            <select class="form-control" name="subject_id" id="subject_id">
                                                <option selected value disabled>Select</option>
                                                @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('subject_id'))
                                                <div class="alert alert-danger">{{ $errors->first('subject_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="chapter_id">Chapter <span class="t_r">*</span></label>
                                            <select class="form-control" name="chapter_id" id="chapter_id">
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
                                        /* .questionArea {
                                            padding: 0 20px;
                                        } */

                                        .question span{
                                            margin-left: 100px;
                                        }
                                        .option{
                                            margin-left: 30px;
                                        }
                                    </style>
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered table-hover w-100" >
                                            <thead>
                                                <tr>
                                                    <th>Question</th>
                                                    <th>Type</th>
                                                    <th>Marks</th>
                                                </tr>
                                            </thead>
                                            <tbody class="questionArea" id="questionArea"></tbody>
                                        </table>
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
                        quesData += '<tr>'
                        quesData += '<input type="hidden" name="type[]" value="'+v.type+'">'
                        quesData += '<td><input type="checkbox" name="question_id[]" value="'+v.id+'">&nbsp;&nbsp; '+v.ques+'</td>'
                        quesData += '<td>'+v.type+'</td>'
                        quesData += '<td>'+v.mark+'</td>'
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

