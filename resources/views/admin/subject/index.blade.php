@extends('admin.layout.master')
@php
    $title = 'Subject';
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
                        <li class="nav-item">Setup</li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">{{ $title }}</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">List of {{ $title }}</h4>
                                    <a data-toggle="modal" data-target="#addModal"
                                        class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                        <i class="fa fa-plus"></i> Add New
                                    </a>
                                </div>
                            </div>
                            <div class="card-body row justify-content-center">
                                <div class="table-responsive">
                                    <table id="DT" class="table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('custom_scripts')
            @can('subject-add')
                @include('admin.subject.create')
            @endcan
            <!-- Datatables -->
            @include('include.data_table')
            <script>
                $(function() {
                    $('#DT').DataTable({
                        processing: true,
                        serverSide: true,
                        deferRender: true,
                        ordering: true,
                        responsive: true,
                        scrollY: 400,
                        ajax: "{{ route('admin.subjects.index') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                title: 'SL',
                                searchable: false,
                                orderable: false,
                            },
                            {
                                data: 'rank.name',
                                name: 'rank.name',
                                title: 'Rank'
                            },
                            {
                                data: 'name',
                                name: 'name',
                                title: 'Name'
                            },
                            {
                                data: 'created_by.name',
                                name: 'created_by.name',
                                title: 'Created By'
                            },
                            {
                                data: 'updated_by.name',
                                name: 'updated_by.name',
                                title: 'Updated By'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                title: 'Action',
                                orderable: false,
                                searchable: false,
                                className: 'text-center',
                                width: '150px'
                            },
                        ],
                        scroller: {
                            loadingIndicator: true
                        },
                        order: [
                            [2, 'asc']
                        ]
                    });
                });
                $(document).ready(function() {
                    $('#rank_id').select2({
                        dropdownParent: $('#addModal'),
                        width: '100%',
                        placeholder: 'Select...',
                        allowClear: true,
                        ajax: {
                            url: window.location.origin + '/admin/select-2-ajax',
                            dataType: 'json',
                            delay: 250,
                            cache: true,
                            data: function(params) {
                                return {
                                    q: $.trim(params.term),
                                    type: 'getRank',
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data
                                };
                            }
                        }
                    });
                });
            </script>
        @endpush
    @endsection
