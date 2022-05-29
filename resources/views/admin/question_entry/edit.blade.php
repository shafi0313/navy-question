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
                    <li class="nav-item"><a href="{{ route('admin.exam.index') }}">Question</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Edit</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Question</div>
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
                        <form action="{{ route('admin.question.update', $question->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_id">Subject <span class="t_r">*</span></label>
                                            <select class="form-control" name="subject_id" id="subject_id">
                                                <option selected value="{{ $question->subject_id }}">{{ $question->subject->name }}</option>
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
                                                <option selected value="{{ $question->chapter_id }}">{{ $question->chapter->name }}</option>
                                            </select>
                                            @if ($errors->has('chapter_id'))
                                                <div class="alert alert-danger">{{ $errors->first('chapter_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr class="bg-danger">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Question Type <span class="t_r">*</span></label>
                                            <select class="form-control" name="type" id="quesType" required>
                                                <option value="Multiple Choice" {{$question->type == 'Multiple Choice' ? 'selected' : ''}}>Multiple Choice</option>
                                                <option value="Short Question" {{$question->type == 'Short Question' ? 'selected' : ''}}>Short Question</option>
                                                <option value="Long Question" {{$question->type == 'Long Question' ? 'selected' : ''}}>Long Question</option>
                                            </select>
                                            @if ($errors->has('type'))
                                                <div class="alert alert-danger">{{ $errors->first('type') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mark">Marks <span class="t_r">*</span></label>
                                            <input name="mark" class="form-control" value="{{ $question->mark }}" required>
                                            @if ($errors->has('mark'))
                                                <div class="alert alert-danger">{{ $errors->first('mark') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ques">Question <span class="t_r">*</span></label>
                                            <textarea name="ques" class="form-control" id="ques" rows="5" required>{{ $question->ques }}</textarea>
                                            @if ($errors->has('ques'))
                                                <div class="alert alert-danger">{{ $errors->first('ques') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($question->type == 'Multiple Choice')
                                    <div class="col-md-6 quesTypeDiv">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Option</th>
                                                <th style="width: 100px;text-align:center;">
                                                    <span class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></span>
                                                </th>
                                            </tr>
                                            @foreach ($question->options as $option)
                                            <tr>
                                                <input type="hidden" name="option_id[]" class="form-control" value="{{ $option->id }}" />
                                                <td><input type="text" name="option[]"  id="option" class="form-control" value="{{ $option->option }}" /></td>
                                                <td class="text-center">
                                                    <span class="btn btn-sm btn-success addrow"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                    <a href="{{ route('admin.question.optionDestroy', $option->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Are you sure')">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            <tbody id="showItem" class=""></tbody>
                                        </table>
                                    </div>
                                    @endif


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

