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
                    <a href="{{route('admin.generatedQues.pdf',$chapters->first()->first()->quesInfo->id)}}" class="btn btn-success btn-sm ml-auto" id="p" style="width: 200px" target="_blank"><i class="fas fa-print"></i> PDF</a>
                    {{-- <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onClick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button> --}}
                </div>
            </div>
                <div class="card-body" id="printableArea">
                    @if (!empty($complete))
                    @include('include.question_paper_head')
                    @endif
                    <div class="row">
                        @php $totalMark = 0; @endphp
                        @foreach ($chapters as $marks)
                            @foreach ($marks as $mark)
                                @php $totalMark += $mark->mark; @endphp
                            @endforeach
                        @endforeach
                        <h2 style="margin-left: 13px; font-weight: bold">Total Mark: {{ $totalMark }}</h2>
                    </div>

                    @php $x = 1 @endphp
                    @foreach ($chapters as $chapter => $questions)
                    <h3>{{$questions->first()->question->chapter->name}}</h3>
                        @foreach ($questions as $question)
                            <div class="questionArea">
                                <h4 class="question">{{$x++}}. {!! $question->ques !!}
                                    <span style="float:right">{{ $question->mark }}
                                        @if (!empty($edit))
                                            <a href="{{route('admin.generateQuestion.edit',[$question->id,$question->ques_info_id])}}" style="margin-left: 20px" class="text-info">Edit</a>
                                        @endif
                                        @if (!empty($delete))
                                            <a href="{{route('admin.generateQuestion.quesDestroy',$question->id)}}" style="margin-left: 20px" class="text-danger">Delete</a>
                                        @endif
                                    </span>
                                </h4>
                                @isset($question->image)
                                <img src="{{asset('uploads/images/question/'.$question->question->image)}}" style="margin-left: 30px"alt="">
                                @endisset
                            </div>
                            @if ($question->options->count() > 0)
                            @foreach ($question->options as $option)
                            <div class="col-md-6 option">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$option->id}}" id="exampleRadios{{$option->id}}">
                                    <label class="form-check-label" for="exampleRadios{{$option->id}}" id="exampleRadios{{$option->id}}">
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
