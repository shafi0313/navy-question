@extends('admin.layout.master')
@section('title', 'Question Paper')
@section('content')
    @php
        $m = '';
        $sm = '';
        $ssm = '';
    @endphp

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Question Paper</li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Final Question Paper</h4>
                                    {{-- <a href="{{ route('admin.questions.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data_table"
                                        class="table table-bordered table-striped table-hover mb-0 w-100">
                                        <thead></thead>
                                        <tbody></tbody>
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
        <script>
            $(function() {
                $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    deferRender: true,
                    ordering: true,
                    // responsive: true,
                    scrollX: true,
                    scrollY: 400,
                    ajax: "{{ route('admin.generated_question.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            title: 'SL',
                            className: "text-center",
                            width: "60px",
                            searchable: false,
                            orderable: false,
                        },
                        {
                            data: 'exam_name',
                            name: 'exam_name',
                            title: 'Exam Name'
                        },
                        {
                            data: 'rank.name',
                            name: 'rank.name',
                            title: 'Rank'
                        },
                        {
                            data: 'date',
                            name: 'date',
                            title: 'Date'
                        },
                        {
                            data: 'time',
                            name: 'time',
                            title: 'Time'
                        },
                        {
                            data: 'duration',
                            name: 'duration',
                            title: 'duration'
                        },
                        // {
                        //     data: 'status',
                        //     name: 'status',
                        //     title: 'Status'
                        // },
                        // {
                        //     data: 'generate',
                        //     name: 'generate',
                        //     title: 'Generate'
                        // },
                        {
                            data: 'set',
                            name: 'set',
                            title: 'Set',
                            className: "text-center",
                            width: "60px",
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'answer',
                            name: 'answer',
                            title: 'Answer',
                            className: "text-center",
                            width: "60px",
                            orderable: false,
                            searchable: false,
                        },
                        // {
                        //     data: 'action',
                        //     name: 'action',
                        //     title: 'Action',
                        //     className: "text-center",
                        //     width: "60px",
                        //     orderable: false,
                        //     searchable: false,
                        // },
                    ],
                    // fixedColumns: false,
                    scroller: {
                        loadingIndicator: true
                    }
                });
            });
        </script>
    @endpush
@endsection
