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
                                    <a href="{{ route('admin.questions.create') }}"
                                        class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                        <i class="fa-solid fa-plus fa-beat fa-lg"></i> Add New Question
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- <div class="row">
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
                                            <label for="subject_id">Subject <span class="t_r">*</span></label>
                                            <select class="form-control" name="subject_id" id="subject_id"
                                                required></select>
                                            @if ($errors->has('subject_id'))
                                                <div class="alert alert-danger">{{ $errors->first('subject_id') }}</div>
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
                                        <table class="table table-striped table-bordered table-hover mt-3 w-100">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Question</th>
                                                    <th>Type</th>
                                                    <th>Marks</th>
                                                    <th style="width:60px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="questionArea" id="questionArea"></tbody>
                                        </table>
                                    </div>
                                </div> --}}


                                <div class="row justify-content-center align-items-end">
                                    {{-- <div class="col">
                                        <div class="form-group my-3">
                                            <label class="form-label" for="exam_id">Exam</label>
                                            <select name="exam_id" id="exam_id" class="form-control">
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col filter">
                                        <div class="form-group my-3">
                                            <label class="form-label" for="only_subject_id">Subject</label>
                                            <select name="subject_id" id="only_subject_id" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col filter">
                                        <div class="form-group my-3">
                                            <label class="form-label" for="rank_id">Rank</label>
                                            <select name="rank_id" id="rank_id" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col filter">
                                        <div class="form-group my-3">
                                            <a href="" class="btn btn-danger">Clear</a>
                                        </div>
                                    </div>
                                </div>



                                <table id="DT" class="table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                    </thead>
                                    <tbody></tbody>
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
        <!-- Datatables -->
        @include('include.data_table')
        @include('admin.question_entry.get-js')
        <script>
            $(function() {
                var table = $('#DT').DataTable({
                    processing: true,
                    serverSide: true,
                    deferRender: true,
                    ordering: true,
                    responsive: true,
                    scrollY: 400,
                    ajax: {
                        url: "{{ route('admin.questions.index') }}",
                        data: function(d) {
                            d.exam_id = $('#exam_id').val();
                            d.subject_id = $('#only_subject_id').val();
                            d.rank_id = $('#rank_id').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            title: 'SL',
                            searchable: false,
                            orderable: false,
                        },
                        {
                            data: 'rank.name',
                            name: 'rank.name',
                            title: 'Rank'
                        },
                        {
                            data: 'subject.name',
                            name: 'subject.name',
                            title: 'Subject'
                        },
                        // {
                        //     data: 'type',
                        //     name: 'type',
                        //     title: 'Type'
                        // },
                        {
                            data: 'ques',
                            name: 'ques',
                            title: 'Question'
                        },
                        {
                            data: 'options',
                            name: 'options',
                            title: 'Options'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            title: 'Action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            width: '150px'
                        },
                    ],
                    scroller: {
                        loadingIndicator: true
                    }
                });

                // Trigger table redraw when the filter is changed
                $(".filter").find('select').on('change', function() {
                    table.draw();
                });

                // Clear filters and redraw table
                $(".filter").find('a').on('click', function(e) {
                    e.preventDefault();
                    $(".filter").find('select').val('').trigger('change');
                    table.draw();
                });
            });
        </script>

        <script>
            // $(document).ready(function() {
            //     // $('#exam_id').select2({
            //     //     width: '100%',
            //     //     placeholder: 'Select...',
            //     //     allowClear: true,
            //     //     ajax: {
            //     //         url: window.location.origin + '/admin/select-2-ajax',
            //     //         dataType: 'json',
            //     //         delay: 250,
            //     //         cache: true,
            //     //         data: function(params) {
            //     //             return {
            //     //                 q: $.trim(params.term),
            //     //                 type: 'getExam',
            //     //             };
            //     //         },
            //     //         processResults: function(data) {
            //     //             return {
            //     //                 results: data
            //     //             };
            //     //         }
            //     //     }
            //     // });
            //     // $('#subject_id').select2({
            //     //     width: '100%',
            //     //     placeholder: 'Select Exam First...',
            //     //     allowClear: true,
            //     //     ajax: {
            //     //         url: window.location.origin + '/admin/select-2-ajax',
            //     //         dataType: 'json',
            //     //         delay: 250,
            //     //         cache: true,
            //     //         data: function(params) {
            //     //             let examId = $('#exam_id').find(":selected").val();
            //     //             return {
            //     //                 q: $.trim(params.term),
            //     //                 type: 'getSubjectByExam',
            //     //                 exam_id: examId
            //     //             };
            //     //         },
            //     //         processResults: function(data) {
            //     //             return {
            //     //                 results: data
            //     //             };
            //     //         }
            //     //     }
            //     // });
            //     // $('#chapter_id').select2({
            //     //     width: '100%',
            //     //     placeholder: 'Select Subject First...',
            //     //     allowClear: true,
            //     //     ajax: {
            //     //         url: window.location.origin + '/admin/select-2-ajax',
            //     //         dataType: 'json',
            //     //         delay: 250,
            //     //         cache: true,
            //     //         data: function(params) {
            //     //             let subject_id = $('#subject_id').find(":selected").val();
            //     //             return {
            //     //                 q: $.trim(params.term),
            //     //                 type: 'getChapterBySubject',
            //     //                 subject_id: subject_id
            //     //             };
            //     //         },
            //     //         processResults: function(data) {
            //     //             return {
            //     //                 results: data
            //     //             };
            //     //         }
            //     //     }
            //     // });
            // })

            // $("#subject_id, #chapter_id").change(function() {
            //     $('#quesType').val('')
            //     $('#questionArea').html('');
            // })
            // $('#quesType').change(function() {
            //     question()
            // });

            // function question() {
            //     $.ajax({
            //         url: '{{ route('admin.questions.read') }}',
            //         method: 'get',
            //         data: {
            //             subject_id: $('#subject_id').val(),
            //             // chapter_id: $('#chapter_id').val(),
            //             type: $('#quesType').val(),
            //         },
            //         success: function(res) {
            //             if (res.status == 'success') {
            //                 $('#questionArea').html(res.html);
            //             }else{
            //                 $('#questionArea').html('<tr><td colspan="5" class="text-center">No Data Found</td></tr>');
            //             }
            //         }
            //     });
            // }
        </script>
    @endpush
@endsection
