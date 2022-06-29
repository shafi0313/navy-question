@extends('admin.layout.master')
@section('title', __('role.permissions'))
@section('content')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">@lang('role.permission')</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Row</h4>
                                @can('permission-add')
                                <a data-toggle="modal" data-target="#createModal"
                                    class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body row justify-content-center">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th class="">{{__('app.id')}}</th>
                                            <th class="">{{__('app.module')}}</th>
                                            <th class="">{{__('app.name')}}</th>
                                            <th class="">{{__('app.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{$permission->id}}</td>
                                            <td>{{ucfirst(str_replace('-', ' ', $permission->module))}}</td>
                                            <td>{{ucfirst(str_replace('-', ' ', $permission->name))}}</td>
                                            <td>
                                                @can('permission-edit')
                                                <a data-route="{{ route('admin.permission.edit', $permission->id) }}"
                                                    data-value="{{$permission->id}}" onclick="ajaxEdit(this)"
                                                    href="javascript:void(0)" class="btn btn-info btn-sm"
                                                    data-bs-placement="top" data-bs-toggle="tooltip"
                                                    data-bs-original-title="@lang('app.edit') @lang('role.permission')"
                                                    title="@lang('app.edit') @lang('role.permission')">
                                                    <i class="fa fa-edit text-white"></i>
                                                </a>
                                                @endcan
                                                @if ($permission->removable && user()->can('permission-delete'))
                                                <a data-route="{{ route('admin.permission.destroy', $permission->id) }}"
                                                    data-value="{{$permission->id}}" onclick="ajaxDelete(this, 'nodt')"
                                                    href="javascript:void(0)" class="btn btn-danger btn-sm"
                                                    data-bs-placement="top" data-bs-toggle="tooltip"
                                                    data-bs-original-title="@lang('app.delete') @lang('role.permission')"
                                                    title="@lang('app.delete') @lang('role.permission')">
                                                    <i class="fa fa-trash text-white"></i>
                                                </a>
                                                @endif
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
    @can('permission-add')
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('app.add') @lang('app.new')
                        @lang('role.permission')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('admin.permission.store') }}"
                    autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="search" name="module"
                                class="form-control @error('module') is-invalid @enderror" id="module"
                                value="{{old('module')}}" placeholder="@lang('app.module') {{ __('app.name') }}">
                            @if ($errors->has('module'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('module') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="search" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{old('name')}}"
                                placeholder="@lang('role.permission') {{ __('app.name') }}">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" data-bs-dismiss="modal">@lang('app.close')</a>
                        <button class="btn btn-primary" type="submit">@lang('app.create')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endcan
    @push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
    @endpush
    @endsection
