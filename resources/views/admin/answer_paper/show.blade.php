@extends('admin.layout.master')
@section('title', 'Answer Paper')
@section('content')
@php $m='answerPaper'; $sm=''; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Question</li>
                </ul>
            </div>

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
                        <form action="{{ route('admin.answerPaper.store') }}" method="POST">
                            @csrf
                            <div class="card-body" id="printableArea">
                                <div class="navy">
                                    <div class="title">
                                        <h2>Bangladesh Navy</h2>
                                        <p>{{ $answerPapers->first()->exam->name }} Exam Question Paper-{{ Carbon\Carbon::parse($answerPapers->first()->exam->date_time)->format('Y') }}</p>
                                        <p>{{ $answerPapers->first()->exam->subject->name }}</p>
                                    </div>
                                    <p><span>Time: {{$answerPapers->first()->exam->time}}</span> <span style="float:right">Total marks: {{$answerPapers->first()->exam->total_mark}}</span> </p>
                                </div>
                                @php $x = 1 @endphp
                                @foreach ($answerPapers as $key => $answerPaper)
                                <input type="hidden" name="question_id[]" value="{{$answerPaper->question_id}}">
                                <div class="questionArea">
                                    <h4 class="question">{{$x++}}. {{ $answerPaper->question->ques }}
                                        <input type="text" name="mark[]" class="form-control" placeholder="Enter Marks" style="width: 250px; display: inline-block">
                                        <span style="float:right">{{ $answerPaper->question->mark }}</span>
                                    </h4>
                                    <p><strong>Answer: </strong>{{ $answerPaper->ans }}</p>
                                    <br>
                                </div>

                                @endforeach

                            </div>
                            <div class="text-center card-action">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    <!-- Datatables -->
    @include('include.data_table')
    <script>
        $(function () {
            $("#checkAll").on("click", function () {
                if($(this).is(":checked")){
                    $('.child').prop('checked', true);
                } else {
                    $('.child').prop('checked', false);
                }
            })
        });
    </script>
@endpush
@endsection

