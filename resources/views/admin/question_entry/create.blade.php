@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
    @php
        $m = '';
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
                        <li class="nav-item"><a href="{{ route('admin.exam.index') }}">Question</a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Create</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="d-flex card-header">
                                <div class="card-title">Add Question</div>
                                <a href="{{ route('admin.question.index') }}"
                                    class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa-solid fa-pen-to-square fa-beat fa-lg"></i> Edit Question
                                </a>
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

                            <form action="{{ route('admin.question.store') }}" method="POST" id="quesStore"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mark">Marks <span class="t_r">*</span></label>
                                                <input type="number" name="mark" class="form-control" id="mark"
                                                    required>
                                                @if ($errors->has('mark'))
                                                    <div class="alert alert-danger">{{ $errors->first('mark') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <input type="file" name="image" class="form-control" id="image">
                                                @if ($errors->has('image'))
                                                    <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ques">Question <span class="t_r">*</span></label>
                                                <textarea name="ques" class="form-control" id="ques" rows="2" required></textarea>
                                                @if ($errors->has('ques'))
                                                    <div class="alert alert-danger">{{ $errors->first('ques') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row quesTypeDiv ml-2" style="display: none">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group ">
                                                <label>Option: </label>
                                                <input type="text" name="option" id="option" class="form-control"
                                                    style="width: 230%">
                                            </div>
                                            <div style="margin-top: 38px; margin-left:238px">
                                                <button class="btn btn-success add-item" type="button">Add</button>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-hover item_data_table">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Option</th>
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
                                <table class="table table-striped table-bordered table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Type</th>
                                            <th>Marks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody class="questionArea" id="questionArea"></tbody> --}}
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
        @include('include.toast');
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
            })



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
                toast('success', 'Added');
                $('.item_data_table tbody').append(html);
                $('#option').val('');
                serialMaintain();
            });

            $('.item_data_table').on('click', '.item-delete', function(e) {
                var element = $(this).parents('tr');
                element.remove();
                toast('warning', 'item removed!');
                e.preventDefault();
                serialMaintain();
            });
            $('#quesType').change(function() {
                $("#questionArea").html('');
                let chapterId = $('#chapter_id').find(":selected").val();
                let quesType = $(this).val();
                $.ajax({
                    url: "{{ route('admin.question.getQuestion') }}",
                    data: {
                        chapterId: chapterId,
                        quesType: quesType
                    },
                    method: 'get',
                    success: res => {
                        if (res.status == 200) {
                            question()
                        } else {
                            // alert('No question found')
                        }
                    },
                    error: err => {
                        // alert('No question found')
                    }
                });
            });

            $('#quesStore').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                let url = $(this).attr('action');
                let method = $(this).attr('method');
                var request = $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: res => {
                        toast('success', 'Success!');
                        clear();
                        question()
                        $(".trData").remove();
                    },
                    error: err => {
                        $.each(err.responseJSON.errors, (i, v) => {
                            toast('error', v);
                        })
                    }
                });
            });

            function clear() {
                $("#questionArea").html('');
                $("#ques").val('');
                // $("#mark").val('');
                $("#option").val('');
                $("#image").val('');
            }

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
                            $('#question').html(res.html);
                        }
                    }
                });
            }

            function getData() {
                return {
                    '_token': "{{ csrf_token() }}",
                    'subject_id': $('#subject_id').val(),
                    'chapter_id': $('#chapter_id').val(),
                    'type': $('#quesType').val(),
                    'mark': $('#mark').val(),
                    'ques': $('#ques').val(),
                    'option': $('#option').val(),
                };
            }

            function serialMaintain() {
                var i = 1;
                var subtotal = gst_amt_subtotal = 0;
                $('.serial').each(function(key, element) {
                    $(element).html(i);
                    i++;
                });
            };

            $("#quesType").change(function() {
                const type = $(this).val();
                if (type == "multiple_choice") {
                    $(".quesTypeDiv").show();
                } else {
                    $(".quesTypeDiv").hide();
                }
            })
        </script>
    @endpush
@endsection
