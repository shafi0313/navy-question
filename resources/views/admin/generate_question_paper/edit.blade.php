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
                        <li class="nav-item"><a href="{{ route('admin.exams.index') }}">Question</a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Edit</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Edit Question</div>
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
                            <form action="{{ route('admin.generate_question.update', $question->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="quesInfoId" value="{{ $quesInfoId }}">
                                <input type="hidden" name="set" value="{{ $set }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rank_id">Rank <span class="t_r">*</span></label>
                                                <select class="form-control" name="rank_id" id="rank_id" required>
                                                    <option value="{{ $question->rank_id }}">{{ $question->rank->name }}
                                                    </option>
                                                </select>
                                                @if ($errors->has('rank_id'))
                                                    <div class="alert alert-danger">{{ $errors->first('rank_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subject_id">Subject <span class="t_r">*</span></label>
                                                <select class="form-control" name="subject_id" id="subject_id" required>
                                                    <option value="{{ $question->subject_id }}">
                                                        {{ $question->subject->name }}</option>
                                                </select>
                                                @if ($errors->has('subject_id'))
                                                    <div class="alert alert-danger">{{ $errors->first('subject_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="type">Question Type <span class="t_r">*</span></label>
                                                <select class="form-control" name="type" id="quesType" required>
                                                    <option value="multiple_choice"
                                                        {{ $question->type == 'multiple_choice' ? 'selected' : '' }}>
                                                        Multiple Choice</option>
                                                    <option value="short_question"
                                                        {{ $question->type == 'short_question' ? 'selected' : '' }}>Short
                                                        Question</option>
                                                    <option value="long_question"
                                                        {{ $question->type == 'long_question' ? 'selected' : '' }}>Long
                                                        Question</option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <div class="alert alert-danger">{{ $errors->first('type') }}</div>
                                                @endif
                                            </div>
                                        </div> --}}

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mark">Marks <span class="t_r">*</span></label>
                                                <input name="mark" class="form-control" value="{{ $question->mark }}"
                                                    required>
                                                @if ($errors->has('mark'))
                                                    <div class="alert alert-danger">{{ $errors->first('mark') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ques">Question <span class="t_r">*</span></label>
                                                <textarea name="ques" class="form-control" id="ques" rows="5" required>{!! $question->ques !!}</textarea>
                                                @if ($errors->has('ques'))
                                                    <div class="alert alert-danger">{{ $errors->first('ques') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        @if ($question->type == 'multiple_choice')
                                            <div class="col-md-8 quesTypeDiv">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>SL</td>
                                                        <th>Option</th>
                                                        <th width="100px">Correct ans</th>
                                                        <th style="width: 100px; text-align:center;" title="Add More">
                                                            <span class="btn btn-sm btn-success add-row">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                    @foreach ($question->options as $option)
                                                        <tr>
                                                            <input type="hidden" name="option_id[]"
                                                                value="{{ $option->id }}" />

                                                            <th class="serial">{{ @$i += 1 }}</th>
                                                            <td>
                                                                <input type="text" name="option[]" id="option"
                                                                    class="form-control" value="{{ $option->option }}" />
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="text" name="correct[]"
                                                                    class="form-control" value="{{ $option->correct == 1 ? 'yes' : 'no' }}"/>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route('admin.questions.optionDestroy', $option->id) }}"
                                                                    class="btn btn-link btn-danger"
                                                                    onclick="return confirm('Are you sure')">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tbody id="showItem" class=""></tbody>
                                                </table>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                                <div class="text-center card-action">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
        @include('admin.question_entry.get-js')

        <script>
            // $('#subject_id').change(function() {
            //     $.ajax({
            //         url: "{{ 'admin.questions.getChapter' }}",
            //         data: {
            //             subjectId: $(this).val()
            //         },
            //         method: 'get',
            //         success: res => {
            //             let opt = '<option disabled selected>- -</option>';
            //             if (res.status == 200) {
            //                 $.each(res.chapters, function(i, v) {
            //                     opt += '<option value="' + v.id + '">' + v.name + '</option>';
            //                 });
            //                 $("#chapter_id").html(opt);
            //             } else {
            //                 alert('No chapter found')
            //             }
            //         },
            //         error: err => {
            //             alert('No chapter found')
            //         }
            //     });
            // });

            // $("#quesType").change(function() {
            //     const type = $(this).val();
            //     if (type == "multiple_choice") {
            //         $(".quesTypeDiv").show();
            //     } else {
            //         $(".quesTypeDiv").hide();
            //     }
            // })
            $(document).ready(function() {
                var i = 1;
                $('.add-row').click(function() {
                    i++;
                    var html = `
                        <tr id="remove_${i}">
                            <td class="serial">${i}</td>
                            <td>
                                <input type="text" name="option[]" class="form-control"/>
                            </td>
                            <td class="text-center">
                                <input type="text" name="correct[]"  class="form-control" />
                            </td>
                            <td style="width: 20px" class="text-center">
                                <span class="btn btn-sm btn-danger" onClick="return remove(${i})">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                            </td>
                        </tr>
                    `;

                    $('#showItem').append(html);
                    updateSerialNumbers();
                });

                window.remove = function(id) {
                    $('#remove_' + id).remove();
                    updateSerialNumbers();
                }

                function updateSerialNumbers() {
                    $('.serial').each(function(index) {
                        $(this).text(index + 1);
                    });
                }
            });
        </script>
    @endpush
@endsection
