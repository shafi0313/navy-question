@extends('user.layout.master')
@section('title', 'Generated Question')
@section('content')
@php $m='generatedQues'; $sm=''; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('user.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Generated Question</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Row</h4>
                                {{-- <a href="{{ route('user.question.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th>SL</th>
                                            <th>Creator Name</th>
                                            <th>Exam</th>
                                            <th>Subject</th>
                                            <th>Date & Time</th>
                                            <th>Question</th>
                                            <th class="no-sort" width="305px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x = 1 @endphp
                                        @foreach ($questions->groupBy('exam_id') as $questio)
                                        @php $question = $questio->first() @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $question->user->name }}</td>
                                            <td>{{ $question->exam->name }}</td>
                                            <td>{{ $question->subject->name }}</td>
                                            <td>{{ Carbon\Carbon::parse($question->exam->date_time)->format('d/m/Y g:i A') }}</td>
                                            {{-- <td>{{ Carbon\Carbon::parse($question->exam->date_time)->diffForHumans(Carbon\Carbon::now()) }}</td> --}}
                                            <td>

                                                <a href="{{ route('user.generatedQues.show', $question->exam_id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Show">
                                                        Show
                                                    </a>
                                            </td>
                                            @php
                                                $init = Carbon\Carbon::parse($question->exam->date_time)->diffInSeconds(Carbon\Carbon::now());
                                                $day = floor($init / 86400);
                                                $hours = floor(($init -($day*86400)) / 3600);
                                                $minutes = floor(($init / 60) % 60);
                                                $seconds = $init % 60;
                                            @endphp

                                            <td>
                                                <div class="form-button-action">
                                                    {{-- <a href="{{ route('user.generatedQues.show', $question->exam_id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Show">
                                                        Show
                                                    </a> --}}
                                                    {{-- <a href="{{ route('user.adminUser.edit', $question->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </a> --}}
                                                    {{-- <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </button> --}}

                                                    @if ($question->enroll->count() > 0)
                                                    {{-- <div class="counter" style='color: green;'>
                                                        <span class='e-m-days'>{{ $day }}</span> Days |
                                                        <span class='e-m-hours'>{{ $hours }}</span> Hours |
                                                        <span class='e-m-minutes'>{{ $minutes }}</span> Minutes |
                                                        <span class='e-m-seconds'>{{ $seconds }}</span> Seconds
                                                      </div> --}}
                                                    @else
                                                    <form action="{{ route('user.generatedQues.enroll') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="exam_id" value="{{ $question->exam_id }}">
                                                        <button type="submit" class="btn btn-primary btn-sm">Enroll</button>
                                                    </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
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
            function getCounterData(obj) {
                var days = parseInt($('.e-m-days', obj).text());
                var hours = parseInt($('.e-m-hours', obj).text());
                var minutes = parseInt($('.e-m-minutes', obj).text());
                var seconds = parseInt($('.e-m-seconds', obj).text());
                return seconds + (minutes * 60) + (hours * 3600) + (days * 3600 * 24);
            }

            function setCounterData(s, obj) {
                var days = Math.floor(s / (3600 * 24));
                var hours = Math.floor((s % (60 * 60 * 24)) / (3600));
                var minutes = Math.floor((s % (60 * 60)) / 60);
                var seconds = Math.floor(s % 60);

                console.log(days, hours, minutes, seconds);

                // if(days==0 && hours==0 && minutes==0 && seconds==1){
                //     alert("Please select")
                // }

                $('.e-m-days', obj).html(days);
                $('.e-m-hours', obj).html(hours);
                $('.e-m-minutes', obj).html(minutes);
                $('.e-m-seconds', obj).html(seconds);
            }

            var count = getCounterData($(".counter"));

            var timer = setInterval(function () {
                count--;
                if (count == 0) {
                    clearInterval(timer);
                    return;
                }
                setCounterData(count, $(".counter"));
            }, 1000);

        });
    </script>
@endpush
@endsection

