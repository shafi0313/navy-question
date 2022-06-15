<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <style>
                .quesType{
                    font-size: 18px;
                    border-bottom: 1px solid gray;
                    margin-bottom: 10px !important;
                }
                .questionArea {
                    padding: 0 20px;
                }
                .option{
                    margin-left: 30px;
                }
                .form-check [type=checkbox]:checked, .form-check [type=checkbox]:not(:checked) {
                    position: absolute;
                    left: 0;
                }
                .form-check, .form-group {
                    margin-bottom: 0;
                    padding: 0px;
                }
            </style>
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onClick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
                <div class="card-body" id="printableArea">
                    {{-- @include('include.question_paper_head') --}}
                    @php $x = 1 @endphp
                    @if($questionPapers->where('type','Multiple Choice')->count() > 0)
                        <h4 class="quesType">Multiple Choice</h4>
                        @foreach ($questionPapers->where('type','Multiple Choice') as $key => $question)
                        <div class="questionArea">
                            <h4 class="question">{{$x++}}. {{ $question->question->ques }}
                                <span style="float:right">{{ $question->question->mark }}
                                    @if (!empty($delete))
                                        <a href="{{route('admin.generateQuestion.quesDestroy',$question->question->id)}}" style="margin-left: 20px" class="text-danger">Delete</a>
                                    @endif
                                </span>

                            </h4>
                            @foreach ($question->question->options as $option)
                            <div class="col-md-6 option">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$option->id}}" id="exampleRadios{{$option->id}}">
                                    <label class="form-check-label" for="exampleRadios{{$option->id}}" id="exampleRadios{{$option->id}}">
                                        {{ $option->option }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        <br>
                        <br>
                    @endif

                    @if ($questionPapers->where('type','Short Question')->count() > 0)
                        <h4 class="quesType">Short Question</h4>
                        @foreach ($questionPapers->where('type','Short Question') as $question)
                        <div class="questionArea">
                            <h4 class="question">{{$x++}}. {{ $question->question->ques }}
                                <span style="float:right">{{ $question->question->mark }}
                                    @if (!empty($delete))
                                        <a href="{{route('admin.generateQuestion.quesDestroy',$question->question->id)}}" style="margin-left: 20px" class="text-danger">Delete</a>
                                    @endif
                                </span>
                            </h4>
                        </div>
                        @endforeach
                        <br>
                        <br>
                    @endif

                    @if ($questionPapers->where('type','Long Question')->count() > 0)
                        <h4 class="quesType">Long Question</h4>
                        @foreach ($questionPapers->where('type','Long Question') as $question)
                        <div class="questionArea">
                            <h4 class="question">{{$x++}}. {{ $question->ques }}
                                <span style="float:right">{{ $question->mark }}
                                    @if (!empty($delete))
                                        <a href="{{route('admin.generateQuestion.quesDestroy',$question->question->id)}}" style="margin-left: 20px" class="text-danger">Delete</a>
                                    @endif
                                </span>
                            </h4>
                        </div>
                        @endforeach
                    @endif
                </div>
        </div>
    </div>
</div>
