<div class="row justify-content-center">
    <div class="col-md-8">
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
            </style>
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onClick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
                <div class="card-body" id="printableArea">
                    <div class="text-center">
                        <h2>Bangladesh Navy</h2>
                        <p>{{ $questions->first()->exam->name }} Exam Question Paper-{{ Carbon\Carbon::parse($questions->first()->exam->date_time)->format('Y') }}</p>
                        <p>{{ $questions->first()->subject->name }}</p>
                    </div>
                    <h4 class="quesType">Multiple Choice</h4>
                    @foreach ($questions->where('type','Multiple Choice') as $key => $question)
                    <div class="questionArea">
                        <h4 class="question">{{ $question->ques }}
                            <span style="float:right">{{ $question->mark }}</span>
                        </h4>
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
                    </div>
                    @endforeach
                    <br>
                    <br>
                    <h4 class="quesType">Short Question</h4>
                    @foreach ($questions->where('type','Short Question') as $question)
                    <div class="questionArea">
                        <h4 class="question">{{ $question->ques }}
                            <span style="float:right">{{ $question->mark }}</span>
                        </h4>
                    </div>
                    @endforeach
                    <br>
                    <br>
                    <h4 class="quesType">Long Question</h4>
                    @foreach ($questions->where('type','Long Question') as $question)
                    <div class="questionArea">
                        <h4 class="question">{{ $question->ques }}
                            <span style="float:right">{{ $question->mark }}</span>
                        </h4>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</div>
