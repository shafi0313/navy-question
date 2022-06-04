@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
@php $m=''; $sm=''; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Mark Distribution</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Mark Distribution Table</h4>
                                <a href="{{ route('admin.markDistribution.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
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
                                {{-- <div class="col-md-6">
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
                                </div> --}}
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover w-100" >
                                        <thead>
                                            <tr>
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
            let subjectId = $('#subject_id').find(":selected").val();
            let id = $(this).val();
            $.ajax({
                url:"{{route('admin.markDistribution.getMarkInfo')}}",
                data:{id:id, subjectId:subjectId},
                method:'get',
                success:res=>{
                    if(res.status == 200){
                        let quesData = '';
                        $.each(res.markDistribution,function(i,v){
                            let id = v.id;
                            let url = '{{ route("admin.markDistribution.edit", ":id") }}';
                            url = url.replace(':id', id);

                            quesData += '<tr>'
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

