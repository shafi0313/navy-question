@extends('admin.layout.master')
@section('title', 'Generate Question')
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
                            <div class="card-header">
                                <div class="card-title">Generate Question</div>
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
                            <form action="{{ route('admin.generate_question.store') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exam_id">Exam <span class="t_r">*</span></label>
                                                <select class="form-control select2" name="exam_id" id="exam_id" required>
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
                                                <label for="subject_id">Subject & Trade <span
                                                        class="t_r">*</span></label>
                                                <select class="form-control select2" name="subject_id" id="subject_id"
                                                    required></select>
                                                @if ($errors->has('subject_id'))
                                                    <div class="alert alert-danger">{{ $errors->first('subject_id') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date">Date <span class="t_r">*</span></label>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ old('date', date('d-m-Y')) }}" required>
                                                @if ($errors->has('date'))
                                                    <div class="alert alert-danger">{{ $errors->first('date') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="time">Time <span class="t_r">*</span></label>
                                                <input type="time" name="time" class="form-control"
                                                    value="{{ old('time', date('h.i A')) }}" required>
                                                @if ($errors->has('time'))
                                                    <div class="alert alert-danger">{{ $errors->first('time') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="duration">Duration <span class="t_r">*</span></label><br>
                                                <input style="width:50%; display: inline-block" type="text"
                                                    name="d_hour" class="form-control" value="{{ old('d_hour') }}"
                                                    placeholder="Hour"
                                                    onInput="this.value = this.value.replace(/[^\d]/g,'');" required>
                                                <input style="width:49%; display: inline-block" type="text"
                                                    name="d_minute" class="form-control" value="{{ old('d_minute') }}"
                                                    placeholder="Minute"
                                                    onInput="this.value = this.value.replace(/[^\d]/g,'');" required>
                                                @if ($errors->has('d_hour'))
                                                    <div class="alert alert-danger">{{ $errors->first('d_hour') }}</div>
                                                @endif
                                                @if ($errors->has('d_minute'))
                                                    <div class="alert alert-danger">{{ $errors->first('d_minute') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mode">Mode <span class="t_r">*</span></label>
                                                <input type="text" name="mode" class="form-control"
                                                    value="{{ old('mode') }}" required>
                                                @if ($errors->has('mode'))
                                                    <div class="alert alert-danger">{{ $errors->first('mode') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" class="form-control"
                                                    value="(Note: Attention is hereby drawn to NR Appendix LVI)">
                                                @if ($errors->has('note'))
                                                    <div class="alert alert-danger">{{ $errors->first('note') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="option_note">Question Option Note</label>
                                                <input type="text" name="option_note" class="form-control"
                                                    value="(Answer all the question)">
                                                @if ($errors->has('option_note'))
                                                    <div class="alert alert-danger">{{ $errors->first('option_note') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pass_mark">Pass Marks <span class="t_r">*</span></label>
                                            <input type="text" name="pass_mark" class="form-control" value="{{ old('pass_mark') }}" onInput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" required>
                                            @if ($errors->has('pass_mark'))
                                            <div class="alert alert-danger">{{ $errors->first('pass_mark') }}</div>
                                        @endif
                                        </div>
                                    </div> --}}


                                        {{-- <div class="col-md-6">
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

                                    <div class="col-md-12">
                                        <hr class="bg-danger">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Question Generate by Percentage</label>
                                            <input type="text" name="percentage" class="form-control">
                                            @if ($errors->has('type'))
                                                <div class="alert alert-danger">{{ $errors->first('type') }}</div>
                                            @endif
                                        </div>
                                    </div>
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
                                    </div> --}}

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
            $('#exam_id').change(function() {
                $.ajax({
                    url: '{{ route('admin.global.getSubject') }}',
                    method: 'get',
                    data: {
                        exam_id: $(this).val(),
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#subject_id').html(res.html);
                        }
                    }
                });
            })

            $('#subject_id').change(function() {
                $.ajax({
                    url: "{{ route('admin.question.getChapter') }}",
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
                        }
                    },
                    error: err => {
                        alert('No chapter found')
                    }
                });
            });

            $('#subject_id').change(function() {
                $.ajax({
                    url: "{{ route('admin.question.getChapter') }}",
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
                        }
                    },
                    error: err => {
                        alert('No chapter found')
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
                            var quesData = '';
                            $.each(res.questions, function(i, v) {
                                quesData += '<tr>'
                                // quesData += '<input type="hidden" name="type" value="'+v.type+'">'
                                quesData +=
                                    '<td><input type="checkbox" name="question_id[]" value="' + v
                                    .id + '">&nbsp;&nbsp; ' + v.ques + '</td>'
                                quesData += '<td>' + v.type + '</td>'
                                quesData += '<td>' + v.mark + '</td>'
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
        <script>
            $("#quesType").change(function() {
                const type = $(this).val();
                if (type == "multiple_choice") {
                    $(".quesTypeDiv").show();
                } else {
                    $(".quesTypeDiv").hide();
                }
            })

            $(document).ready(function() {
                var i = 1;
                $('.addrow').click(function() {
                    i++;
                    html = '';
                    html += '<tr id="remove_' + i + '" class="post_item">';
                    html +=
                        '	<td><input type="text" name="option[]" id="purchase_" class="form-control form-control-sm"/></td>';
                    html +=
                        '	<td style="width: 20px"  class="col-md-2"><span class="btn btn-sm btn-danger" onclick="return remove(' +
                        i + ')"><i class="fa fa-times" aria-hidden="true"></i></span></td>';
                    html += '</tr>';
                    $('#showItem').append(html);
                });
            });

            function remove(id) {
                $('#remove_' + id).remove();
                total_price();
            }
        </script>
    @endpush
@endsection
