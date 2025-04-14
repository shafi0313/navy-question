@extends('admin.layout.master')
@php
    if ($questionInfo->status == 1) {
        $quesStatus = 'ড্রাফট';
    } else {
        $quesStatus = 'ফাইনাল';
    }
    $rank = $questionInfo->rank->id;
@endphp
@section('title', $quesStatus . ' প্রশ্ন গ্রুপ ' . bnNumber($rank) . '- ' . questionSetBn($set))
@section('content')
    @php
        $m = 'generatedQues';
        $sm = '';
        $ssm = '';
        $complete = 'c';
    @endphp
    @include('admin.question_paper.css')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Question Paper</li>
                    </ul>
                </div>
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title"></h4>
                        <a href="{{ route('admin.generated_question.show', [$questionInfo->id, $questionSubjectInfos->first()->set, 'pdf']) }}"
                            class="btn btn-success ml-auto" id="p" style="width: 250px" target="_blank"><i
                                class="fas fa-print"></i> PDF Download</a>
                    </div>
                </div>
                @include('include.question_paper')
            </div>
        </div>
        @include('include.footer')
    </div>

    @push('custom_scripts')
        <!-- Datatables -->
        @include('include.data_table')
        @include('include.printJS')
        <script>
            $(function() {
                $("#checkAll").on("click", function() {
                    if ($(this).is(":checked")) {
                        $('.child').prop('checked', true);
                    } else {
                        $('.child').prop('checked', false);
                    }
                })
            });
        </script>
    @endpush
@endsection
