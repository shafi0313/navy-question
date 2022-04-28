@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
@php $m='question'; $sm=''; $ssm=''; @endphp

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
                                <h4 class="card-title">Add Row</h4>
                                <a href="{{ route('admin.question.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
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
                                            <th>By</th>
                                            <th>Subject</th>
                                            <th>Chapter</th>
                                            <th>Type</th>
                                            <th>Question</th>
                                            <th>Mark</th>
                                            <th>Date & Time</th>
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
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x = 1 @endphp
                                        @foreach ($questions as $question)
                                        {{-- @php $question = $questio->first() @endphp --}}
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $question->user->name }}</td>
                                            <td>{{ $question->subject->name }}</td>
                                            <td>{{ $question->chapter->name }}</td>
                                            <td>{{ $question->type }}</td>
                                            <td>{{ $question->ques }}</td>
                                            <td>{{ $question->mark }}</td>
                                            <td>{{ examDateTime($question->created_at) }}</td>
                                            {{-- <td>{{ $question->subject->name }}</td> --}}
                                            <td>
                                                <div class="form-button-action">
                                                    {{-- <a href="{{ route('admin.question.show', $question->exam_id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Show">
                                                        Show
                                                    </a> --}}
                                                    {{-- <a href="{{ route('admin.question.create', $question->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Show">
                                                        Question Entry
                                                    </a> --}}
                                                    {{-- <a href="{{ route('admin.adminUser.edit', $question->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
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

