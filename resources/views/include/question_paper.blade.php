<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <style>
                .quesType {
                    font-size: 18px;
                    border-bottom: 1px solid gray;
                    margin-bottom: 10px !important;
                }

                .questionArea {
                    padding: 0 20px;
                }

                .question p {
                    display: inline-block !important;
                }

                .option {
                    margin-left: 30px;
                }

                .form-check [type=checkbox]:checked,
                .form-check [type=checkbox]:not(:checked) {
                    position: absolute;
                    left: 0;
                }

                .form-check,
                .form-group {
                    margin-bottom: 0;
                    padding: 0px;
                }
            </style>
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <a href="{{ route('admin.generated_question.show', [$quesInfo->id, $chapters->first()->first()->set, 'pdf']) }}"
                        class="btn btn-success ml-auto" id="p" style="width: 250px" target="_blank"><i
                            class="fas fa-print"></i> PDF Download</a>
                </div>
            </div>
            <div class="card-body" id="printableArea">
                @if (!empty($complete))
                    @include('include.question_paper_head')
                @endif
                <div class="row">
                    <h2 style="margin-left: auto; font-weight: bold; padding-right: 25px">Total Mark:
                        {{ $totalQuesMark }}</h2>
                </div>

                @php $x = 1; @endphp

                @foreach ($chapters as $chapterName => $questions)
                    <h3><u>{{ $chapterName }}</u></h3>
                    @foreach ($questions as $question)
                        <input type="hidden" name="ques_id" class="ques_id" value="{{ $question->id }}">
                        <div class="questionArea">
                            <h4 class="question">{{ $x++ }}. {!! $question->question->ques !!}
                                <span style="float:right">{{ $question->question->mark }}
                                    @if (!empty($edit))
                                        <a href="{{ route('admin.generate_question.edit', [$question->id, $question->ques_info_id]) }}"
                                            style="margin-left: 20px" class="text-info">Edit</a>
                                    @endif
                                    @if (!empty($delete))
                                        <a href="{{ route('admin.generate_question.quesDestroy', [$question->id, $question->ques_info_id]) }}"
                                            style="margin-left: 20px" class="text-danger">Delete</a>
                                    @endif
                                </span>
                            </h4>
                            @if (isset($question->question->image))
                                <img src="{{ asset('uploads/images/question/' . $question->question->image) }}"
                                    style="margin-left: 30px" alt="">
                            @endif
                        </div>
                        @if ($question->options->isNotEmpty())
                            @foreach ($question->options as $option)
                                <div class="col-md-6 option">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $option->id }}"
                                            id="exampleRadios{{ $option->id }}">
                                        <label class="form-check-label" for="exampleRadios{{ $option->id }}">
                                            {{ $option->option }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
