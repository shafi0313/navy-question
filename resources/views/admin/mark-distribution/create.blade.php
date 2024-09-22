@extends('admin.layout.master')
@php
    $title = 'Mark Distribution';
@endphp
@section('title', $title)
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item"><a href="{{ route('admin.mark-distributions.index') }}">{{ $title }}</a>
                        </li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Create</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Add {{ $title }}</div>
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

                            <form action="{{ route('admin.mark-distributions.store') }}" method="POST" id="quesStore">
                                @csrf
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mark">Marks <span class="t_r">*</span></label>
                                                <input type="text" name="mark" class="form-control digitOnly"
                                                    required>
                                                @if ($errors->has('mark'))
                                                    <div class="alert alert-danger">{{ $errors->first('mark') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center card-action">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                    <button type="reset" class="btn btn-danger">Cancel</button>
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
        @include('include.toast');
        @include('include.create');
        <script>
            $('#subject_id').change(function() {
                $.ajax({
                    url: "{{ route('admin.questions.getChapter') }}",
                    data: {
                        subjectId: $(this).val()
                    },
                    method: 'get',
                    success: res => {
                        let opt = '<option disabled selected>- -</option>';
                        if (res.status == 200) {
                            $.each(res.chapters, function(i, v) {
                                opt += '<option value="' + v.id + '">' + v.name + '</option>';
                            });
                            $("#chapter_id").html(opt);
                        } else {
                            alert('No chapter found')
                            // toast('error', 'No Codes found')
                        }
                    },
                    error: err => {
                        alert('No chapter found')
                        // toast('error', 'No Codes found')
                    }
                });
            });
            $('#quesType').change(function() {
                $("#questionArea").html('');
                let chapterId = $('#chapter_id').find(":selected").val();
                let quesType = $(this).val();
                $.ajax({
                    url: "{{ route('admin.generate_question.getQuestion') }}",
                    data: {
                        chapterId: chapterId,
                        quesType: quesType
                    },
                    method: 'get',
                    success: res => {
                        if (res.status == 200) {
                            let quesData = '';
                            $.each(res.questions, function(i, v) {
                                let id = v.id;
                                let url = '{{ route('admin.questions.edit', ':id') }}';
                                url = url.replace(':id', id);

                                quesData += '<tr>'
                                // quesData += '<input type="hidden" name="type" value="'+v.type+'">'
                                quesData +=
                                    '<td><input type="checkbox" name="question_id[]" value="' + v
                                    .id + '">&nbsp;&nbsp; ' + v.ques + '</td>'
                                quesData += '<td>' + v.type + '</td>'
                                quesData += '<td>' + v.mark + '</td>'
                                quesData += '<td>'
                                quesData += '<div class="form-button-action">'
                                quesData += '<a href=' + url +
                                    ' data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">Edit</a>'
                                quesData += '</div>'
                                quesData += '</td>'
                                quesData += '</tr>'
                            });
                            $("#questionArea").append(quesData);
                        } else {
                            alert('No question found')
                        }
                    },
                    error: err => {
                        alert('No question found')
                    }
                });
            });
        </script>
    @endpush
@endsection
