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
                    <li class="nav-item">Question</li>
                </ul>
            </div>

            @include('include.question_paper')
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
    <script>
        function printDiv(divName) {
            $("#footer_signature_area").show();
            $("div").removeClass("dataTables_length, table-responsive");
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            $("body, table thead tr th, table thead, table tr th, table tbody tr th, table tbody tr td, table tfoot tr td").css("color", "black");
            // $("table thead tr th, table thead, table tr th").css("background", "red");
            // $("table, table tr").css("border","1px solid gray");
            $(".no-print, .dataTables_filter, #multi-filter-select_length, #multi-filter-select_info, #multi-filter-select_paginate").css("display", "none");
             window.print();
             document.body.innerHTML = originalContents;
        }
    </script>

@endpush
@endsection

