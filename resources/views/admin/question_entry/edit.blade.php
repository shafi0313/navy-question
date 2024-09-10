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
                            <form action="{{ route('admin.questions.update', $question->id) }}" method="post">
                                @csrf @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="only_subject_id">Subject <span class="t_r">*</span></label>
                                                <select class="form-control" name="subject_id" id="only_subject_id"
                                                    required>
                                                    <option value="{{ $question->subject_id }}"
                                                        @selected($question->subject_id == $question->subject->id)>{{ $question->subject->name }}</option>
                                                </select>
                                                @if ($errors->has('subject_id'))
                                                    <div class="alert alert-danger">{{ $errors->first('subject_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rank_id">Batch <span class="t_r">*</span></label>
                                                <select class="form-control" name="rank_id" id="rank_id" required>
                                                    <option value="{{ $question->rank_id }}" @selected($question->rank_id == $question->rank->id)>
                                                        {{ $question->rank->name }}</option>
                                                </select>
                                                @if ($errors->has('rank_id'))
                                                    <div class="alert alert-danger">{{ $errors->first('rank_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type">Question Type <span class="t_r">*</span></label>
                                                <select class="form-control" name="type" id="quesType" required>
                                                    <option selected value disabled>Select</option>
                                                    <option value="multiple_choice" @selected($question->type == 'multiple_choice')>Multiple
                                                        Choice</option>
                                                    <option value="short_question" @selected($question->type == 'short_question')>Short
                                                        Question</option>
                                                    <option value="long_question" @selected($question->type == 'long_question')>Long Question
                                                    </option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <div class="alert alert-danger">{{ $errors->first('type') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
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
                                        @if ($question->type == 'multiple_choice')
                                            <div class="col-md-6 ml-2 quesTypeDiv">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Options</th>
                                                        <th style="width: 100px;text-align:center;">
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-toggle="modal" data-target="#newOptionAdd">
                                                                Add
                                                            </button>
                                                        </th>
                                                    </tr>
                                                    @foreach ($question->options as $option)
                                                        <tr>
                                                            <input type="hidden" name="option_id[]" class="form-control"
                                                                value="{{ $option->id }}" />
                                                            <td><input type="text" name="option[]" id="option"
                                                                    class="form-control" value="{{ $option->option }}" />
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route('admin.questions.optionDestroy', $option->id) }}"
                                                                    data-toggle="tooltip" title=""
                                                                    class="btn btn-link btn-danger"
                                                                    data-original-title="Remove"
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

    <!-- Modal -->
    <div class="modal fade" id="newOptionAdd" tabindex="-1" role="dialog" aria-labelledby="newOptionAddLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newOptionAddLabel">Add New Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.questions.newOptionAdd') }}" method="POST">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="option">Option <span class="t_r">*</span></label>
                                <input name="option" class="form-control" required>
                                @if ($errors->has('option'))
                                    <div class="alert alert-danger">{{ $errors->first('option') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('custom_scripts')
        @include('admin.question_entry.get-js')
        <script>
            $("#quesType").change(function() {
                const type = $(this).val();
                if (type == "multiple_choice") {
                    $(".quesTypeDiv").show();
                } else {
                    $(".quesTypeDiv").hide();
                }
            })
            // $(document).ready(function() {
            //     var i = 1;
            //     $('.addrow').click(function() {
            //         i++;
            //         html = '';
            //         html += '<tr id="remove_' + i + '" class="post_item">';
            //         html += '	<input type="hidden" name="option_id[]" value="{{ $option->id ?? 0 }}">';
            //         html +=
            //             '	<td><input type="text" name="option[]" id="purchase_" class="form-control form-control-sm"/></td>';
            //         html +=
            //             '	<td style="width: 20px"  class="col-md-2"><span class="btn btn-sm btn-danger" onClick="return remove(' +
            //             i + ')"><i class="fa fa-times" aria-hidden="true"></i></span></td>';
            //         html += '</tr>';
            //         $('#showItem').append(html);
            //     });
            // });

            // function remove(id) {
            //     $('#remove_' + id).remove();
            //     total_price();
            // }
        </script>
    @endpush
@endsection
