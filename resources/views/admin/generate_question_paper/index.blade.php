@extends('admin.layout.master')
@section('title', 'Generate Question')
@section('content')
@php $m='generateQuestion'; $sm=''; $ssm=''; @endphp

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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                {{-- <h4 class="card-title">Add Row</h4> --}}
                                {{-- <a href="{{ route('admin.question.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
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
                                            {{-- <th>Creator Name</th> --}}
                                            <th>Exam</th>
                                            <th>Subject</th>
                                            <th class="no-sort" width="40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x = 1 @endphp
                                        @foreach ($exams as $exam)
                                        {{-- @php $exam = $questio->first() @endphp --}}
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            {{-- <td>{{ $exam->user->name }}</td> --}}
                                            <td>{{ $exam->name }}</td>
                                            <td>{{ $exam->subject->name }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('admin.generateQuestion.create', $exam->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Generate">
                                                        Generate
                                                    </a> ||
                                                    <a href="{{ route('admin.generateQuestion.show', $exam->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Question">
                                                        Edit Question
                                                    </a>
                                                    {{-- <a href="{{ route('admin.adminUser.edit', $exam->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </a> --}}
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
 @include('include.footer')
</div>

@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
@endpush
@endsection

