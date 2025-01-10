@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
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
                            <div class="d-flex card-header">
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

                            <form action="{{ route('admin.questions.store') }}" method="POST" id="quesStore"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" value="multiple_choice">
                                <div class="card-body">
                                    <div class="row">
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exam_id">Exam <span class="t_r">*</span></label>
                                                <select class="form-control" name="exam_id" id="exam_id" required>
                                                </select>
                                                @if ($errors->has('exam_id'))
                                                    <div class="alert alert-danger">{{ $errors->first('exam_id') }}</div>
                                                @endif
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rank_id">Rank <span class="t_r">*</span></label>
                                                <select class="form-control" name="rank_id" id="rank_id"
                                                    required></select>
                                                @if ($errors->has('rank_id'))
                                                    <div class="alert alert-danger">{{ $errors->first('rank_id') }}</div>
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
                                        {{-- <div class="col-md-6">
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
                                        </div> --}}
                                        
                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="type">Is Important <span class="t_r">*</span></label>
                                                <select name="important" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mark">Marks <span class="t_r">*</span></label>
                                                <input type="number" name="mark" class="form-control" id="mark"
                                                    required>
                                                @if ($errors->has('mark'))
                                                    <div class="alert alert-danger">{{ $errors->first('mark') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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

                                    <div class="row mt-4 justify-content-center">
                                        <div class="col-md-10">
                                            <table class="table table-bordered table-hover">
                                                <tr>
                                                    <td>Option</td>
                                                    <td>Answer</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="option" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id="correct" class="form-check"
                                                            style="display: inline-block">
                                                        <label for="correct" class="form-label">Correct</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-sm add-item"
                                                            type="button">Add</button>
                                                    </td>
                                                </tr>
                                            </table>
                                            
                                            <table class="table table-bordered table-hover item_data_table">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Option</th>
                                                        <th>Correct</th>
                                                        <th width="50px"></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="text-center card-action">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
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
        @include('include.toast');
        @include('admin.question_entry.get-js')
        <script>
            $('.add-item').on('click', function() {
                const option = $('#option').val();
                const isCorrect = $('#correct').prop('checked');
                let correct, correctText;

                if (isCorrect) {
                    correct = 1;
                    correctText = 'Yes';
                } else {
                    correct = 0;
                    correctText = 'No';
                }
                if (option === '') {
                    alert('This option field is required');
                    $('#option').focus();
                    return false;
                }

                var html = `
                    <tr class="trData">
                        <td class="serial"></td>
                        <td>${option}</td>
                        <td>${correctText}</td>
                        <td align="center">
                            <input type="hidden" name="option[]" value="${option}" />
                            <input type="hidden" name="correct[]" value="${correct}" />
                            <a class="item-delete" href="#"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                `;

                toast('success', 'Added');
                $('.item_data_table tbody').append(html);
                $('#option').val('');
                $('#correct').prop('checked', false);
                serialMaintain();
            });
            $('.item_data_table').on('click', '.item-delete', function(e) {
                e.preventDefault();
                var element = $(this).parents('tr');
                element.remove();
                toast('warning', 'item removed!');
                serialMaintain();
            });

            $('#quesStore').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                let url = $(this).attr('action');
                let method = $(this).attr('method');
                showLoadingAnimation();
                var request = $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: res => {
                        hideLoadingAnimation();
                        clear();
                        swal({
                            icon: 'success',
                            title: 'Success',
                            text: res.message
                        });
                    },
                    error: err => {
                        hideLoadingAnimation();
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: err.responseJSON.message
                        });
                    }
                });
            });

            function clear() {
                $("#questionArea").html('');
                $("#ques, #option, #image").val('');
                $(".item_data_table tbody").empty();
            }

            function serialMaintain() {
                var i = 1;
                var subtotal = gst_amt_subtotal = 0;
                $('.serial').each(function(key, element) {
                    $(element).html(i);
                    i++;
                });
            };
        </script>
    @endpush
@endsection
