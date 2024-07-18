@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
    @php
        $m = 'question';
        $sm = '';
        $ssm = '';
    @endphp

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
                                    <a href="{{ route('admin.question.create') }}"
                                        class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                        <i class="fa-solid fa-plus fa-beat fa-lg"></i> Add New Question
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="alert alert-info text-center"
                                            title="প্রশ্ন সম্পাদনা বা মুছে ফেলার জন্য নীচের ক্ষেত্রগুলি নির্বাচন করুন">
                                            <i class="fa-solid fa-circle-info fa-beat text-info"></i>
                                            Select the below fields to edit or delete question
                                        </h2>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exam_id">Exam <span class="t_r">*</span></label>
                                            <select class="form-control" name="exam_id" id="exam_id" required>
                                            </select>
                                            @if ($errors->has('exam_id'))
                                                <div class="alert alert-danger">{{ $errors->first('exam_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_id">Subject & Trade <span class="t_r">*</span></label>
                                            <select class="form-control" name="subject_id" id="subject_id"
                                                required></select>
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
                                        <table class="table table-striped table-bordered table-hover w-100">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
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
            $(document).ready(function() {
                $('#exam_id').select2({
                    width: '100%',
                    placeholder: 'Select...',
                    allowClear: true,
                    ajax: {
                        url: window.location.origin + '/admin/select-2-ajax',
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            return {
                                q: $.trim(params.term),
                                type: 'getExam',
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        }
                    }
                });
                $('#subject_id').select2({
                    width: '100%',
                    placeholder: 'Select Exam First...',
                    allowClear: true,
                    ajax: {
                        url: window.location.origin + '/admin/select-2-ajax',
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            let examId = $('#exam_id').find(":selected").val();
                            return {
                                q: $.trim(params.term),
                                type: 'getSubjectByExam',
                                exam_id: examId
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        }
                    }
                });
                $('#chapter_id').select2({
                    width: '100%',
                    placeholder: 'Select Subject First...',
                    allowClear: true,
                    ajax: {
                        url: window.location.origin + '/admin/select-2-ajax',
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            let subject_id = $('#subject_id').find(":selected").val();
                            return {
                                q: $.trim(params.term),
                                type: 'getChapterBySubject',
                                subject_id: subject_id
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        }
                    }
                });
            })

            $("#subject_id, #chapter_id").change(function() {
                $('#quesType').val('')
                $('#questionArea').html('');
            })
            $('#quesType').change(function() {
                question()
            });

            function question() {
                $.ajax({
                    url: '{{ route('admin.question.read') }}',
                    method: 'get',
                    data: {
                        subject_id: $('#subject_id').val(),
                        chapter_id: $('#chapter_id').val(),
                        type: $('#quesType').val(),
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#questionArea').html(res.html);
                        }else{
                            $('#questionArea').html('<tr><td colspan="5" class="text-center">No Data Found</td></tr>');
                        }
                    }
                });
            }
        </script>
    @endpush
@endsection
