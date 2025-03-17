@extends('admin.layout.master')
@section('title', 'Question Delete')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Question Delete</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">List of Data</h4>
                                    {{-- <a data-toggle="modal" data-target="#exam-add"
                                        class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                        <i class="fa fa-plus"></i> Add New Exam
                                    </a> --}}
                                </div>
                            </div>
                            <div class="card-body row justify-content-center">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr  class="text-center">
                                                <th>Title</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Question</td>
                                                <td class="text-center">{{ $questions }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('admin.deletes.question') }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return(confirm('This will also delete the draft and final question paper. Are you sure?'))">Delete All</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Draft Question Paper</td>
                                                <td class="text-center">{{ $draftQuestion }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('admin.deletes.draft_ques') }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return(confirm('Are you sure?'))">Delete All</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Final Question Paper</td>
                                                <td class="text-center">{{ $finalQuestion }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('admin.deletes.final_ques') }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return(confirm('Are you sure?'))">Delete All</button>
                                                    </form>
                                                </td>
                                            </tr>
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
        @endpush
    @endsection
