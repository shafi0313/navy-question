@extends('admin.layout.master')
@section('title', 'User')
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">User</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">List of Users</h4>
                                    <a data-toggle="modal" data-target="#user-add"
                                        class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                        <i class="fa fa-plus"></i> Add New User
                                    </a>
                                </div>
                            </div>
                            <div class="card-body row justify-content-center">
                                <table id="userDT" class="table table-striped table-hover">
                                    <thead class="bg-secondary thw"></thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('user-add')
            @include('admin.user.create')
        @endcan

        @push('custom_scripts')
            <!-- Datatables -->
            @include('include.data_table')
            <script>
                $(function() {
                    $('#userDT').DataTable({
                        processing: true,
                        serverSide: true,
                        deferRender: true,
                        ordering: true,
                        responsive: true,
                        scrollY: 400,
                        ajax: "{{ route('admin.users.index') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                title: 'SL',
                                searchable: false,
                                orderable: false,
                            },
                            {
                                data: 'name',
                                name: 'name',
                                title: 'Name'
                            },
                            {
                                data: 'roleName',
                                name: 'roleName',
                                title: 'Permission'
                            },
                            {
                                data: 'email',
                                name: 'email',
                                title: 'Email'
                            },
                            {
                                data: 'mobile',
                                name: 'mobile',
                                title: 'Phone'
                            },
                            {
                                data: 'image',
                                name: 'image',
                                title: 'Image',
                            },
                            {
                                data: 'address',
                                name: 'address',
                                title: 'Address'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                title: 'Action',
                                width: '100px',
                                className: 'text-center',
                                orderable: false,
                                searchable: false
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
