@extends('admin.layout.master')
@section('title', 'Admin User')
@section('content')
@php $m='setup'; $sm='exam'; $ssm=''; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('admin.exam.index') }}">Exam</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Create</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Exam</div>
                        </div>
                        <form action="{{ route('admin.exam.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Exam/Course Name <span class="t_r">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                            @if ($errors->has('name'))
                                            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code <span class="t_r">*</span></label>
                                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                                            @if ($errors->has('code'))
                                            <div class="alert alert-danger">{{ $errors->first('code') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_time">Date & Time <span class="t_r">*</span></label>
                                            <input type="datetime-local" name="date_time" class="form-control" value="{{ old('date_time') }}" required>
                                            @if ($errors->has('date_time'))
                                            <div class="alert alert-danger">{{ $errors->first('date_time') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duration">Duration <span class="t_r">*</span></label>
                                            <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="Ex: 1:30" required>
                                            @if ($errors->has('duration'))
                                            <div class="alert alert-danger">{{ $errors->first('duration') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mode">Mode <span class="t_r">*</span></label>
                                            <input type="text" name="mode" class="form-control" value="{{ old('mode') }}" required>
                                            @if ($errors->has('mode'))
                                            <div class="alert alert-danger">{{ $errors->first('mode') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="trade">Trade</label>
                                            <input type="text" name="trade" class="form-control" value="{{ old('trade') }}" required>
                                            @if ($errors->has('trade'))
                                            <div class="alert alert-danger">{{ $errors->first('trade') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_mark">Total Marks <span class="t_r">*</span></label>
                                            <input type="text" name="total_mark" class="form-control" value="{{ old('total_mark') }}" onInput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" required>
                                            @if ($errors->has('total_mark'))
                                            <div class="alert alert-danger">{{ $errors->first('total_mark') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pass_mark">Pass Marks <span class="t_r">*</span></label>
                                            <input type="text" name="pass_mark" class="form-control" value="{{ old('pass_mark') }}" onInput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" required>
                                            @if ($errors->has('pass_mark'))
                                            <div class="alert alert-danger">{{ $errors->first('pass_mark') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center card-action">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
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
@endpush
@endsection

