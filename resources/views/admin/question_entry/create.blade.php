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
                        {{-- <form>
                            @csrf --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_id">Subjects <span class="t_r">*</span></label>
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
                                            <label for="chapter_id">Chapters <span class="t_r">*</span></label>
                                            <select class="form-control" name="chapter_id" id="chapter_id">
                                                {{-- <option selected value disabled>Select</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach --}}
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
                                                <option selected value disabled>Select</option>
                                                <option value="Multiple Choice">Multiple Choice</option>
                                                <option value="Short Question">Short Question</option>
                                                <option value="Long Question">Long Question</option>
                                            </select>
                                            @if ($errors->has('type'))
                                                <div class="alert alert-danger">{{ $errors->first('type') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mark">Marks <span class="t_r">*</span></label>
                                            <input name="mark" class="form-control" id="mark" required>
                                            @if ($errors->has('mark'))
                                                <div class="alert alert-danger">{{ $errors->first('mark') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ques">Question <span class="t_r">*</span></label>
                                            <textarea name="ques" class="form-control" id="ques" rows="5" required></textarea>
                                            @if ($errors->has('ques'))
                                                <div class="alert alert-danger">{{ $errors->first('ques') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 quesTypeDiv" style="display: none">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Option</th>
                                                <th style="width: 20px;text-align:center;">
                                                    <span class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="option[]" id="option" class="form-control" /></td>
                                                <td style="width: 20px"><span class="btn btn-sm btn-success addrow"><i class="fa fa-plus" aria-hidden="true"></i></span></td>
                                            </tr>
                                            <tbody id="showItem" class=""></tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>


                            </div>
                            <div class="text-center card-action">
                                <button id="add" class="btn btn-primary">Add</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        {{-- </form> --}}
                        <div class="col-md-12">
                            <hr class="bg-danger">
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-primary">Question</h3>
                            <div class="questionArea" id="questionArea"></div>
                            <div class="questionArea" id="question"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.footer')
</div>

@push('custom_scripts')
<script>
    // question()
      $('#add').click(function (e) {
          e.preventDefault();
        var data = getData();
        var request = $.ajax({
            url: "{{ route('admin.question.store') }}",
            method: "GET",
            data: data,
        });
        request.done(function( response ) {
            // clear();
            question()
            $("#questionArea").html('');
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus + jqXHR.responseText );
        });

    });

    function question(){
        $.ajax({
            url:'{{route("admin.question.read")}}',
            method:'get',
            data:{
                subject_id : $('#subject_id').val(),
                chapter_id : $('#chapter_id').val(),
            },
            success: function (res) {
                if (res.status == 'success') {
                    $('#question').html(res.html);
                }
            }
        });
    }
    function getData() {
        return {
            '_token':"{{ csrf_token() }}",
            'subject_id' : $('#subject_id').val(),
            'chapter_id' : $('#chapter_id').val(),
            'type' : $('#quesType').val(),
            'mark' : $('#mark').val(),
            'ques' : $('#ques').val(),
            'option' : $('#option').val(),
        };
    }

</script>
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
                            quesData += '<label>&nbsp;&nbsp; </label>'+v.ques+'';
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

