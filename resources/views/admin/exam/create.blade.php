@extends('admin.layout.master')
@section('title', 'Admin User')
@section('content')
@php $m='exam'; $sm=''; $ssm=''; @endphp
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
                                            <label for="name">Exam Name <span class="t_r">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                            @if ($errors->has('name'))
                                            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_id">Subject Name <span class="t_r">*</span></label>
                                            <select name="subject_id" class="form-control" required>
                                                <option value="">Select</option>
                                                @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('subject_id'))
                                            <div class="alert alert-danger">{{ $errors->first('subject_id') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Exam Code <span class="t_r">*</span></label>
                                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                                            @if ($errors->has('code'))
                                            <div class="alert alert-danger">{{ $errors->first('code') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_time">Exam Date & Time <span class="t_r">*</span></label>
                                            <input type="datetime-local" name="date_time" class="form-control" value="{{ old('date_time') }}" required>
                                            @if ($errors->has('date_time'))
                                            <div class="alert alert-danger">{{ $errors->first('date_time') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="time">Exam Duration <span class="t_r">*</span></label>
                                            <input type="text" name="time" class="form-control" value="{{ old('time') }}" required>
                                            @if ($errors->has('time'))
                                            <div class="alert alert-danger">{{ $errors->first('time') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_ques">Total Question <span class="t_r">*</span></label>
                                            <input type="text" name="total_ques" class="form-control" value="{{ old('total_ques') }}" onInput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" required>
                                            @if ($errors->has('total_ques'))
                                            <div class="alert alert-danger">{{ $errors->first('total_ques') }}</div>
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

