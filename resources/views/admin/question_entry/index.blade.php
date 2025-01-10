@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
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
                                    <h4 class="card-title">Show Questions</h4>
                                    <a href="{{ route('admin.questions.create') }}"
                                        class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                        <i class="fa-solid fa-plus fa-lg"></i> Add New Question
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row justify-content-center align-items-end">
                                    <div class="col filter">
                                        <div class="form-group my-3">
                                            <label class="form-label" for="only_subject_id">Subject</label>
                                            <select name="subject_id" id="only_subject_id" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col filter">
                                        <div class="form-group my-3">
                                            <label class="form-label" for="rank_id">Branch</label>
                                            <select name="rank_id" id="rank_id" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col filter">
                                        <div class="form-group my-3">
                                            <a href="" class="btn btn-danger">Clear</a>
                                        </div>
                                    </div>
                                </div>


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
        @include('include.footer')
    </div>

    @push('custom_scripts')
        <!-- Datatables -->
        @include('include.data_table')
        @include('admin.question_entry.get-js')
        <script>
            $(function() {
                var table = $('#DT').DataTable({
                    processing: true,
                    serverSide: true,
                    deferRender: true,
                    ordering: true,
                    responsive: true,
                    scrollY: 400,
                    ajax: {
                        url: "{{ route('admin.questions.index') }}",
                        data: function(d) {
                            d.exam_id = $('#exam_id').val();
                            d.subject_id = $('#only_subject_id').val();
                            d.rank_id = $('#rank_id').val();
                        }
                    },
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
                            data: 'subject.name',
                            name: 'subject.name',
                            title: 'Subject'
                        },
                        {
                            data: 'ques',
                            name: 'ques',
                            title: 'Question'
                        },
                        {
                            data: 'options',
                            name: 'options',
                            title: 'Options',
                            width: '200px'
                        },
                        {
                            data: 'important',
                            name: 'important',
                            title: 'Important',
                            className: 'text-center',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            title: 'Action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            width: '100px'
                        },
                    ],
                    scroller: {
                        loadingIndicator: true
                    },
                    order: [
                        [0]
                    ],
                });

                // Trigger table redraw when the filter is changed
                $(".filter").find('select').on('change', function() {
                    table.draw();
                });

                // Clear filters and redraw table
                $(".filter").find('a').on('click', function(e) {
                    e.preventDefault();
                    $(".filter").find('select').val('').trigger('change');
                    table.draw();
                });
            });
        </script>
    @endpush
@endsection
