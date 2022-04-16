@extends('user.layout.master')
@section('title', 'Dashboard')
@section('content')
@php $m='dashboard'; $sm=''; $ssm=''; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner mt-5">
            <div class="row mt-2">
            </div>
        </div>
    </div>
    @include('admin.layout.footer')
</div>

@push('custom_scripts')

@endpush
@endsection

