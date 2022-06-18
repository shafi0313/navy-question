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
                        <input type="hidden" name="subject_id" value="{{$questionPapers->first()->question->subject_id}}" id="subject_id">
                        <input type="hidden" name="ques_info_id" value="{{$questionPapers->first()->ques_info_id}}" id="ques_info_id">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="chapter_id">Chapter <span class="t_r">*</span></label>
                                        <select class="form-control select2" name="chapter_id" id="chapter_id">
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

                                <div class="col-md-6">
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

@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
    <script>
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
                            let id = v.id;
                            let url = '{{ route("admin.question.edit", ":id") }}';
                            url = url.replace(':id', id);
                            quesData += '<tr>'
                            quesData += '<td><input type="checkbox" name="question_id[]" value="'+v.id+'">&nbsp;&nbsp; '+v.ques+'</td>'
                            quesData += '<td>'+v.type+'</td>'
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
    </script>
@endpush
@endsection

