@extends('admin.layout.master')
@section('title', 'Generated Question')
@section('content')
@php $m='generatedQues'; $sm=''; $ssm=''; @endphp

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
                        </style>
                            <div class="card-body">
                                <h4 class="quesType">Multiple Choice</h4>
                                @foreach ($questions->where('type','Multiple Choice') as $key => $question)
                                <div class="questionArea">
                                    <h4 class="question">{{ $question->ques }}
                                        <span style="float:right">{{ $question->mark }}</span>
                                    </h4>
                                    @foreach ($question->options as $option)
                                    <div class="col-md-6 option">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="{{$option->id}}" id="exampleRadios{{$option->id}}">
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

