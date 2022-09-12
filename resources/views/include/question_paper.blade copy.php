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
                .question p{
                    display: inline-block !important;
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
                    <a href="{{route('admin.generatedQues.pdf',$questionPapers->first()->quesInfo->id)}}" class="btn btn-success btn-sm ml-auto" id="p" style="width: 200px" target="_blank"><i class="fas fa-print"></i> PDF</a>
                    {{-- <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onClick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button> --}}
                </div>
            </div>
                <div class="card-body" id="printableArea">
                    @if (!empty($complete))
                    @include('include.question_paper_head')
                    @endif
                    <div class="row">
                        @php $i = 0; @endphp
                        @foreach ($questionPapers as $item)
                        @php $i += $item->question->mark; @endphp
                        @endforeach
                        <h2 style="margin-left: 13px; font-weight: bold">Total Mark: {{ $i }}</h2>
                    </div>
                    @php $x = 1 @endphp
                    @if($questionPapers->where('type','multiple_choice')->count() > 0)
                        <h4 class="quesType">Multiple Choice</h4>
                        @foreach ($questionPapers->where('type','multiple_choice') as $key => $question)
                        <div class="questionArea">
                            <h4 class="question">{{$x++}}. {!! $question->question->ques !!}
                                <span style="float:right">{{ $question->question->mark }}
                                    @if (!empty($edit))
                                        <a href="{{route('admin.generateQuestion.edit',[$question->question->id,$question->ques_info_id])}}" style="margin-left: 20px" class="text-info">Edit</a>
                                    @endif
                                    @if (!empty($delete))
                                        <a href="{{route('admin.generateQuestion.quesDestroy',$question->question->id)}}" style="margin-left: 20px" class="text-danger">Delete</a>
                                    @endif
                                </span>
                            </h4>
                            @isset($question->question->image)
                            <img src="{{asset('uploads/images/question/'.$question->question->image)}}" style="margin-left: 30px"alt="">
                            @endisset

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
                    @if ($questionPapers->where('type','short_question')->count() > 0)
                        <h4 class="quesType">Short Question</h4>
                        @foreach ($questionPapers->where('type','short_question') as $question)
                        <div class="questionArea">
                            <h4 class="question">{{$x++}}. {!! $question->question->ques !!}
                                <span style="float:right">{{ $question->question->mark }}
                                    @if (!empty($edit))
                                    <a href="{{route('admin.generateQuestion.edit',[$question->question->id,$question->ques_info_id])}}" style="margin-left: 20px" class="text-info">Edit</a>
                                @endif
                                @if (!empty($delete))
                                    <a href="{{route('admin.generateQuestion.quesDestroy',$question->question->id)}}" style="margin-left: 20px" class="text-danger" onclick="return confirm('Are you sure')">Delete</a>
                                @endif
                            </span>
                        </h4>
                        @isset($question->question->image)
                        <img src="{{asset('uploads/images/question/'.$question->question->image)}}" alt="">
                        @endisset
                        </div>
                        @endforeach
                        <br>
                        <br>
                    @endif
                    @if ($questionPapers->where('type','long_question')->count() > 0)
                        <h4 class="quesType">Long Question</h4>
                        @foreach ($questionPapers->where('type','long_question') as $question)
                        <div class="questionArea">
                            <h4 class="question">{{$x++}}. {!! $question->question->ques !!}
                                <span style="float:right">{{ $question->question->mark }}
                                    @if (!empty($edit))
                                        <a href="{{route('admin.generateQuestion.edit',[$question->question->id,$question->ques_info_id])}}" style="margin-left: 20px" class="text-info">Edit</a>
                                    @endif
                                    @if (!empty($delete))
                                        <a href="{{route('admin.generateQuestion.quesDestroy',$question->question->id)}}" style="margin-left: 20px" class="text-danger">Delete</a>
                                    @endif
                                </span>
                            </h4>
                            @isset($question->question->image)
                            <img src="{{asset('uploads/images/question/'.$question->question->image)}}" alt="">
                            @endisset
                        </div>
                        @endforeach
                    @endif
                </div>
        </div>
    </div>
</div>
