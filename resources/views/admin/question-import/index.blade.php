@extends('admin.layout.master')
@php
    $title = 'Import Questions';
@endphp
@section('title', $title)
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Question</li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">{{ $title }}</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                            </div>
                            <form action="{{ route('admin.question_imports.imports') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="form-group col-sm-4">
                                        <label for="file">File
                                            <span class="t_r"> *
                                                <a href="{{ asset('uploads/Question-format.xlsx') }}" download>Download
                                                    Excel Format</a>
                                            </span>
                                        </label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>

                                    <div class="col-md-3" style="margin-top: 40px">
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                </div>
                            </form>

                            <form action="{{ route('admin.question-imports.store') }}" method="post">
                                @csrf @method('POST')
                                <input type="hidden" name="type" value="multiple_choice">
                                <div class="row justify-content-center">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="rank_id">Rank <span class="t_r">*</span></label>
                                                    <select class="form-control" name="rank_id" id="rank_id"
                                                        required></select>
                                                    @if ($errors->has('rank_id'))
                                                        <div class="alert alert-danger">{{ $errors->first('rank_id') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subject_id">Subject <span class="t_r">*</span></label>
                                                    <select class="form-control" name="subject_id" id="subject_id"
                                                        required></select>
                                                    @if ($errors->has('subject_id'))
                                                        <div class="alert alert-danger">{{ $errors->first('subject_id') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col-md-12 text-right">
                                                <a href="{{ route('admin.question_imports.all_deletes') }}"
                                                    onclick="return confirm('Do you want to delete all data on this page?')"
                                                    class="btn btn-danger mr-3">Delete All</a>
                                                    
                                                <button type="submit" onclick="return confirm('Are you sure?')"
                                                    class="btn btn-primary">Post</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($questions->count() > 0)
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive mt-3">
                                        <table class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Question</th>
                                                    <th>Option 1</th>
                                                    <th>Option 2</th>
                                                    <th>Option 3</th>
                                                    <th>Option 4</th>
                                                    <th>Mark</th>
                                                    <th>Correct Option</th>
                                                    <th class="no-sort" width="60px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($questions as $question)
                                                    <tr>
                                                        <td>{{ $question->ques }}</td>
                                                        <td>{{ $question->option_1 }}</td>
                                                        <td>{{ $question->option_2 }}</td>
                                                        <td>{{ $question->option_3 }}</td>
                                                        <td>{{ $question->option_4 }}</td>
                                                        <td>{{ $question->mark }}</td>
                                                        <td>{{ $question->correct }}</td>
                                                        <td class="text-center">
                                                            <form
                                                                action="{{ route('admin.question-imports.destroy', $question->id) }}"
                                                                method="post"
                                                                onclick="return confirm('Do you want to delete this data?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" title="Delete"
                                                                    class="btn btn-link btn-danger">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-body">
                                    <div class="alert alert-info">No data found!</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom_scripts')
        <!-- Datatables -->
        @include('include.data_table')
        @include('admin.question_entry.get-js')
    @endpush
@endsection
