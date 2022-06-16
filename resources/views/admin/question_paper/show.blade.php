@extends('admin.layout.master')
@section('title', 'Generated Question')
@section('content')
@php $m='generatedQues'; $sm=''; $ssm=''; $complete='c' @endphp

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

            @include('include.question_paper')
        </div>
    </div>
 @include('include.footer')
</div>

@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
    {{-- @include('include.printJs') --}}
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

