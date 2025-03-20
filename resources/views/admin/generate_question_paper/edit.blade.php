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
                                                <textarea name="ques" class="form-control" id="ques" rows="2" required>{!! $question->ques !!}</textarea>
                                                @if ($errors->has('ques'))
                                                    <div class="alert alert-danger">{{ $errors->first('ques') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        @if ($question->type == 'multiple_choice')
                                            <div class="col-md-12 quesTypeDiv">
                                                <table class="table table-bordered item_data_table">
                                                    <tr>
                                                        <td>Add New Option</td>
                                                        <td width="80px">Answer</td>
                                                        <td width="50px"></td>
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

                                                <hr class="my-5">

                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>SL</td>
                                                        <th>Old Option</th>
                                                        <th width="100px">Correct Ans</th>
                                                        <th style="width: 100px; text-align:center;" title="Add More">
                                                            Action
                                                        </th>
                                                    </tr>

                                                    @foreach ($question->options as $option)
                                                        <tr>
                                                            <input type="hidden" name="option_id[]"
                                                                value="{{ $option->id }}" />

                                                            <th width="40px" class="serial">{{ @$i += 1 }}</th>
                                                            <td>
                                                                <input type="text" name="option[]"
                                                                    class="form-control option"
                                                                    value="{!! old('value') ?? $option->option !!}" />
                                                            </td>
                                                            <td class="text-center">
                                                                <select name="correct[]">
                                                                    <option value="0">No</option>
                                                                    <option value="1" @selected($option->correct == 1)>Yes</option>
                                                                </select>


                                                                {{-- <input type="text" name="correct[]" class="form-control"
                                                                    value="{{ $option->correct == 1 ? 'yes' : 'no' }}" /> --}}
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
        <script type="text/javascript" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

        @include('include.toast');
        @include('include.summer-note');
        @include('admin.question_entry.get-js')

        <script>
            $(document).ready(function() {
                // Define the custom button for inserting LaTeX equations
                var LatexButton = function(context) {
                    var ui = $.summernote.ui;
                    var button = ui.button({
                        contents: '<i class="note-icon-pencil"></i> Insert Equation',
                        tooltip: 'Insert LaTeX Equation',
                        click: function() {
                            var latex = prompt('Enter LaTeX code:', '\\frac{a}{b}');
                            if (latex) {
                                var math = `\\(${latex}\\)`;
                                context.invoke('editor.pasteHTML', math); // Insert as proper HTML
                                // Re-render MathJax if available
                                if (window.MathJax) {
                                    MathJax.typeset();
                                }
                            }
                        }
                    });
                    return button.render();
                };

                // Initialize Summernote with the custom LaTeX button
                $('#option').summernote({
                    height: 100,
                    toolbar: [
                        ['style', ['bold', 'italic']],
                        ['insert', ['latex']]
                    ],
                    buttons: {
                        latex: LatexButton
                    }
                });
                $('.option').each(function() {
                    let value = $(this).val(); // Get the value from the input
                    $(this).summernote({
                        height: 100,
                        toolbar: [
                            ['style', ['bold', 'italic']],
                            ['insert', ['latex']]
                        ],
                        buttons: {
                            latex: LatexButton
                        },
                        callbacks: {
                            onChange: function(contents) {
                                $(this).closest('td').find('.option').val(contents); // Update the hidden input value
                            }
                        }
                    }).summernote('code', value); // Set the value in Summernote
                });

                // Handle adding items to the table
                $('.add-item').on('click', function() {
                    const option = $('#option').summernote('code').trim(); // Get rich text
                    const isCorrect = $('#correct').prop('checked');
                    let correct, correctText;

                    if (isCorrect) {
                        correct = 1;
                        correctText = 'Yes';
                    } else {
                        correct = 0;
                        correctText = 'No';
                    }

                    if (option === '' || option === '<p><br></p>') { // Handle empty Summernote
                        alert('This option field is required');
                        $('#option').summernote('focus');
                        return false;
                    }

                    var html = `
                        <tr class="trData">
                            <td class="serial"></td>
                            <td>${option}</td> <!-- ✅ Corrected: Equation now appears here -->
                            <td>${correctText}</td>
                            <td align="center">
                                <input type="hidden" name="option[]" value='${option.replace(/'/g, "&#39;")}' />
                                <input type="hidden" name="correct[]" value="${correct}" />
                                <a class="item-delete text-danger" href="#"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    `;

                    toast('success', 'Added');
                    // $('.item_data_table tbody').append(html);
                    $('#showItem').append(html);
                    // $('.option').summernote('code', ''); // Clear Summernote
                    $('#option').summernote('code', ''); // Clear Summernote
                    $('#correct').prop('checked', false);
                    serialMaintain();

                    // Re-render MathJax to process new equations
                    if (window.MathJax) {
                        MathJax.typeset();
                    }
                });

                // Handle deletion of dynamically added rows
                $(document).on('click', '.item-delete', function(e) {
                    e.preventDefault();
                    $(this).closest('tr').remove();
                    serialMaintain();
                });
            });

            // $(document).ready(function() {
            //     var i = 1;
            //     $('.add-row').click(function() {
            //         i++;
            //         var html = `
    //             <tr id="remove_${i}">
    //                 <td class="serial">${i}</td>
    //                 <td>
    //                     <input type="text" name="option[]" class="form-control"/>
    //                 </td>
    //                 <td class="text-center">
    //                     <input type="text" name="correct[]"  class="form-control" />
    //                 </td>
    //                 <td style="width: 20px" class="text-center">
    //                     <span class="btn btn-sm btn-danger" onClick="return remove(${i})">
    //                         <i class="fa fa-times" aria-hidden="true"></i>
    //                     </span>
    //                 </td>
    //             </tr>
    //         `;

            //         $('#showItem').append(html);
            //         updateSerialNumbers();
            //     });

            //     window.remove = function(id) {
            //         $('#remove_' + id).remove();
            //         updateSerialNumbers();
            //     }

            //     function updateSerialNumbers() {
            //         $('.serial').each(function(index) {
            //             $(this).text(index + 1);
            //         });
            //     }
            // });
        </script>
    @endpush
@endsection
