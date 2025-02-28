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
                        <li class="nav-item"><a href="{{ route('admin.exams.index') }}">Question</a></li>
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
                                            {{-- Question Info --}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exam_name">Exam Name <span
                                                                class="t_r">*</span></label>
                                                        <input type="text" name="exam_name" class="form-control"
                                                            value="{{ old('exam_name') }}" required>
                                                        @if ($errors->has('exam_name'))
                                                            <div class="alert alert-danger">
                                                                {{ $errors->first('exam_name') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="rank_id">Rank <span class="t_r">*</span></label>
                                                        <select class="form-control" name="rank_id" id="rank_id"
                                                            required></select>
                                                        @if ($errors->has('rank_id'))
                                                            <div class="alert alert-danger">{{ $errors->first('rank_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date">Date <span class="t_r">*</span></label>
                                                        <input type="date" name="date" class="form-control"
                                                            value="{{ old('date', date('d-m-Y')) }}" required>
                                                        @if ($errors->has('date'))
                                                            <div class="alert alert-danger">{{ $errors->first('date') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="time">Time </label>
                                                        <input type="time" name="time" class="form-control"
                                                            value="{{ old('time', date('h.i A')) }}">
                                                        @if ($errors->has('time'))
                                                            <div class="alert alert-danger">{{ $errors->first('time') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="duration">Duration </label><br>

                                                        <input style="width:50%; display: inline-block" type="text"
                                                            name="d_hour" class="form-control" value="{{ old('d_hour') }}"
                                                            placeholder="Hour"
                                                            onInput="this.value = this.value.replace(/[^\d]/g,'');">

                                                        <input style="width:49%; display: inline-block" type="text"
                                                            name="d_minute" class="form-control"
                                                            value="{{ old('d_minute') }}" placeholder="Minute"
                                                            onInput="this.value = this.value.replace(/[^\d]/g,'');">

                                                        @if ($errors->has('d_hour'))
                                                            <div class="alert alert-danger">{{ $errors->first('d_hour') }}
                                                            </div>
                                                        @endif
                                                        @if ($errors->has('d_minute'))
                                                            <div class="alert alert-danger">
                                                                {{ $errors->first('d_minute') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            {{-- Subject Table --}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="fw-bold">Subjects</p>
                                                    <table class="table table-bordered subjectTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Subject Name</th>
                                                                <th>Mark</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="note">Note</label>
                                                <textarea name="note" class="form-control" rows="3">সঠিক উত্তরটি নির্বাচন করে সরবরাহকৃত উত্তর পত্রে বৃত্ত পূরণ করতে হবে । যে উত্তরটি সঠিক, উত্তর পত্রের বিষয় ভিত্তিক প্রশ্ন নম্বরে প্রদত্ত ক্রমিকে(ক, খ, গ, ঘ/a, b, c, d) বৃত্ত পূরণ করতে হবে। যেমন 'খ' উত্তরটি সঠিক হলে উত্তর পত্রের বিষয় ভিত্তিক প্রশ্ন নম্বরের 'খ' উত্তরটিতে বৃত্ত পূরণ করতে হবে। একটি প্রশ্নের জন্য একটি উত্তর পূরণ করতে হবে। একাধিক বৃত্ত পূরণ করলে তা বাতিল বলে গণ্য হবে।</textarea>
                                                @if ($errors->has('note'))
                                                    <div class="alert alert-danger">{{ $errors->first('note') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="comment">Comment</label>
                                                <textarea name="comment" class="form-control" rows="2"></textarea>
                                                @if ($errors->has('comment'))
                                                    <div class="alert alert-danger">{{ $errors->first('comment') }}</div>
                                                @endif
                                            </div>
                                        </div>
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
                $('#rank_id').select2({
                    width: '100%',
                    placeholder: 'Type to search...',
                    allowClear: true,
                    ajax: {
                        url: window.location.origin + '/admin/select-2-ajax',
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            return {
                                q: $.trim(params.term),
                                type: 'getRank',
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        }
                    }
                });


                $('#rank_id').on('change', function() {
                    var rank_id = $(this).val();
                    $.ajax({
                        type: 'get',
                        url: '{{ route('admin.generate_question.getSubject') }}',
                        data: {
                            rank_id: rank_id
                        },
                        success: function(res) {
                            if (res.status === 200) {
                                let subjectData = res.subjects.map(subject => `
                                    <tr>
                                        <input type="hidden" name="subject_id[]" value="${subject.id}" />
                                        <td>${subject.name}</td>
                                        <td>
                                            <input type="text" name="mark[]" class="form-control" />
                                        </td>
                                    </tr>
                                `).join('');

                                if (subjectData) {
                                    $(".subjectTable tbody").append(subjectData);
                                } else {
                                    alert('No subject found');
                                }
                            } else {
                                alert('No subject found');
                            }
                        }
                    });
                });
            })
        </script>
    @endpush
@endsection
