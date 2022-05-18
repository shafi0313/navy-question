@extends('admin.layout.master')
@section('title', 'Exam')
@section('content')
@php $m='setup'; $sm='exam'; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Exam</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Row</h4>
                                <a href="{{ route('admin.exam.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th>SL</th>
                                            <th>Exam/Course</th>
                                            <th>Code</th>
                                            <th>Trade</th>
                                            <th>Mode</th>
                                            <th>Date & Time</th>
                                            <th>Duration</th>
                                            <th>Total Mark</th>
                                            <th>Pass Mark</th>
                                            <th>States</th>
                                            <th>Created at</th>
                                            <th class="no-sort" width="40px">Action</th>
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x = 1 @endphp
                                        @foreach ($exams as $exam)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $exam->name }}</td>
                                            <td>{{ $exam->code }}</td>
                                            <td>{{ $exam->trade }}</td>
                                            <td>{{ $exam->mode }}</td>
                                            <td>{{ examDateTime($exam->date_time) }}</td>
                                            <td>{{ $exam->d_hour}}:{{ $exam->d_minute}}</td>
                                            <td>{{ $exam->total_mark }}</td>
                                            <td>{{ $exam->pass_mark }}</td>
                                            <td>{{ $exam->status }}</td>
                                            <td>{{ examDateTime($exam->created_at) }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('admin.adminUser.edit', $exam->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </button>
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
@endpush
@endsection

