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

                        <form action="{{ route('admin.question.store') }}" method="POST" id="quesStore" enctype="multipart/form-data">
                            @csrf
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
                                            </select>
                                            @if ($errors->has('chapter_id'))
                                                <div class="alert alert-danger">{{ $errors->first('chapter_id') }}</div>
                                            @endif
                                        </div>
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
                                            <input type="text" name="mark" class="form-control" id="mark" required>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" name="image" class="form-control" id="image" >
                                            @if ($errors->has('image'))
                                                <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row quesTypeDiv ml-2" style="display: none">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group " >
                                            <label>Option: </label>
                                            <input type="text" name="option" id="option" class="form-control" style="width: 230%">
                                        </div>
                                        <div style="margin-top: 38px; margin-left:238px">
                                            <button class="btn btn-success add-item" type="button">Add</button>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-hover item-table">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th >Option</th>
                                                <th width="50px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="text-center card-action">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <hr class="bg-danger">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.footer')
</div>

@push('custom_scripts')
<script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('ques')
</script>
@include('include.toast');
<script>
    $('.add-item').on('click', function() {
        var option = $('#option').val();
        if (option == '') {
            alert('This option field is required');
            $('#option').focus();
            return false;
        }
        var html = '<tr>';
        html += '<tr class="trData"><td class="serial"></td><td>' + option + '</td><td align="center">';
        html += '<input type="hidden" name="option[]" value="' + option + '" />';
        html += '<a class="item-delete" href="#"><i class="fas fa-trash"></i></a></td></tr>';
        toast('success','Added');
        $('.item-table tbody').append(html);
        $('#option').val('');
        serialMaintain();
    });

    $('.item-table').on('click', '.item-delete', function(e) {
        var element = $(this).parents('tr');
        element.remove();
        toast('warning','item removed!');
        e.preventDefault();
        serialMaintain();
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
                        question()
                        // let quesData = '';
                        // $.each(res.questions,function(i,v){
                        //     let id = v.id;
                        //     let url = '{{ route("admin.question.edit", ":id") }}';
                        //     url = url.replace(':id', id);
                        //     quesData += '<tr>'
                        //     quesData += '<td><input type="checkbox" name="question_id[]" value="'+v.id+'">&nbsp;&nbsp; '+v.ques+'</td>'
                        //     quesData += '<td>'+v.type+'</td>'
                        //     quesData += '<td>'+v.mark+'</td>'
                        //     quesData += '<td>'
                        //     quesData +=     '<div class="form-button-action">'
                        //     quesData +=         '<a href='+url+' data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">Edit</a>'
                        //     quesData +=     '</div>'
                        //     quesData += '</td>'
                        //     quesData += '</tr>'
                        // });
                        // $("#questionArea").append(quesData);
                    }else{
                        alert('No question found')
                    }
                },
                error:err=>{
                    alert('No question found')
                }
            });
        });

    $('#quesStore').on('submit',function(e){
        e.preventDefault();
        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        var formData = new FormData(this);
        let url    = $(this).attr('action');
        let method = $(this).attr('method');
        var request = $.ajax({
            url: url,
            method:method,
            data: formData,
            contentType: false,
            processData: false,
            success:res=>{
                toast('success','Success!');
                clear();
                question()
                $(".trData").remove();
                // if(res.status == 200){
                //     toast('success','Success!');
                //     clear();
                //     question()

                //  toast('success', res.message);
                // }else{
                //     toast('error',res.message);
                // }
            },
            error:err=>{
                $.each(err.responseJSON.errors, (i,v)=>{
                    toast('error', v);
                })
            }
        });
    });

    function clear() {
        $("#questionArea").html('');
        $("#ques").val('');
        $("#mark").val('');
        $("#option").val('');
        $("#image").val('');
        CKEDITOR.instances.ques.setData('')
    }

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

    function serialMaintain() {
        var i = 1;
        var subtotal = gst_amt_subtotal=0;
        $('.serial').each(function(key, element) {
            $(element).html(i);
            i++;
        });
    };
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
</script>

@endpush
@endsection

