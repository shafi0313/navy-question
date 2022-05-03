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
                .title h4{
                    padding: 0;
                    margin: 0;
                }
            </style>
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onClick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
                <div class="card-body" id="printableArea">
                    <div class="navy">
                        <div class="title">
                            <h4>CONFIDENTIAL</h4>
                            <h4>EXAM IN CONFIDENCE</h4>
                            <h4>PROGRAM EXAM FOR THE RANK OF </h4>
                            <h4>TRADE:</h4>
                            <h4>SUBJECT: {{ $questionPapers->first()->question->subject->name }}</h4>
                            {{-- <p>{{ $questionPapers->first()->exam->name }} Exam Question Paper-{{ Carbon\Carbon::parse($questionPapers->first()->exam->date_time)->format('Y') }}</p> --}}
                            <table class="table table-bordered text-left">
                                <tr>
                                    <td>Mode of Examination</td>
                                    <td> :</td>
                                    <td>Total Marks</td>
                                    <td> : {{$questionPapers->first()->exam->total_mark}}</td>
                                </tr>
                                <tr>
                                    <td>Duration of Examination</td>
                                    <td> : {{$questionPapers->first()->exam->time}}</td>
                                    <td>Pass Marks</td>
                                    <td>:</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @php $x = 1 @endphp
                    @if($questionPapers->where('type','Multiple Choice')->count() > 0)
                        <h4 class="quesType">Multiple Choice</h4>
                        @foreach ($questionPapers->where('type','Multiple Choice') as $key => $question)
                        <div class="questionArea">
                            <h4 class="question">{{$x++}}. {{ $question->question->ques }}
                                <span style="float:right">{{ $question->question->mark }}</span>
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
                                <span style="float:right">{{ $question->question->mark }}</span>
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
                                <span style="float:right">{{ $question->mark }}</span>
                            </h4>
                        </div>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
