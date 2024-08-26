@extends('admin.layout.master')
@section('title', 'Mark Distribution')
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Mark Distribution</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">List of Exams</h4>
                                </div>
                            </div>
                            <div class="card-body row justify-content-center">
                                <div class="table-responsive">
                                    <table id="DT" class="table table-striped table-hover">
                                        <thead class="bg-secondary thw"></thead>
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
            {{-- @can('mark-distribution-add')
                @include('admin.mark-distribution.create')
            @endcan --}}
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
                        ajax: "{{ route('admin.mark-distributions.index') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false,
                                orderable: false,
                            },
                            {
                                data: 'name',
                                name: 'name',
                                title: 'Exam Name'
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
                        }
                    });
                });
            </script>
        @endpush
    @endsection
