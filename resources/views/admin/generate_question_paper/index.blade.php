@extends('admin.layout.master')
@section('title', 'Generate Question')
@section('content')
@php $m=''; $sm=''; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Generate Question</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="align-items-center">
                                <a href="{{ route('admin.generateQuestion.create') }}" class="btn btn-primary btn-round text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Generate New Question
                                </a>
                                <h4 class="card-title">Draft Question Paper</h4>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th>SL</th>
                                            <th>Exam</th>
                                            <th>Year</th>
                                            <th>Exam Mode</th>
                                            <th>Exam Trade</th>
                                            <th>Exam Date & Time</th>
                                            <th class="no-sort" width="40px">Subject</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x = 1 @endphp
                                        @foreach ($datum as $dat)
                                        @php
                                            $data = $dat->first()
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            {{-- <td>{{ $question->user->name }}</td> --}}
                                            <td>{{ $data->exam->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->date)->format('Y') }}</td>
                                            <td>{{ $data->mode }}</td>
                                            <td>{{ $data->trade }}</td>
                                            <td>{{ examDateTime($data->date) }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('admin.generateQuestion.showBySubject', \Carbon\Carbon::parse($data->date)->format('Y')) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Show">
                                                        Show by Subject
                                                    </a>

                                                    {{-- <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </button> --}}
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

@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
@endpush
@endsection

