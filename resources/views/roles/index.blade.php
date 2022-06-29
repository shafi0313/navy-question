@extends('admin.layout.master')
@section('title', __('role.title'))
@section('content')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">@lang('role.role')</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Row</h4>
                                @if (user()->id == 1)
                                    <a href="{{route('admin.permission.index')}}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                        <i class="fa fa-plus"></i>@lang('app.manage') @lang('role.permissions')</a>
                                    </a>
                                    @endif
                                    @can('role-add')
                                    <a data-toggle="modal" data-target="#createModal" class="btn btn-primary btn-round text-light" style="min-width: 200px">
                                        <i class="fa fa-plus"></i> @lang('app.add') @lang('role.role')
                                    </a>
                                    @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body row justify-content-center">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th class="">{{ __('app.id') }}</th>
                                            <th class="">{{ __('app.name') }}</th>
                                            <th class="">{{ __('app.total') }} @lang('app.users')</th>
                                            <th class="">{{ __('app.created_at') }}</th>
                                            {{-- <th class="">{{ __('app.updated_at') }}</th> --}}
                                            <th class="">{{ __('app.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td>{{ ucfirst($role->name) }}</td>
                                            <td>{{ $role->users->count() }}</td>
                                            <td>{{ $role->created_at->format('d M, Y h:i A') }}</td>
                                            {{-- <td>{{ $role->updated_at->format('d M, Y H:i A') }}</td> --}}
                                            <td>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="mx-1">
                                                            @can('permission-change')
                                                            <a href="{{ route('admin.role.show', $role->id) }}" class="btn btn-success btn-sm" data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('role.update-permission')" title="@lang('role.update-permission')">
                                                                <i class="fa-solid fa-shield"></i>
                                                            </a>
                                                            @endcan
                                                            @can('role-edit')
                                                            <a data-route="{{ route('admin.role.edit', $role->id) }}" data-value="{{$role->id}}" onclick="ajaxEdit(this)" href="javascript:void(0)" class="btn btn-info btn-sm" data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('app.edit') @lang('role.role')" title="@lang('app.edit') @lang('role.role')">
                                                                <i class="fa fa-edit text-white"></i>
                                                            </a>
                                                            @endcan
                                                        @if ($role->removable && user()->can('role-delete'))
                                                            <a data-route="{{ route('admin.role.destroy', $role->id) }}"  data-value="{{$role->id}}" onclick="ajaxDelete(this, 'nodt')" href="javascript:void(0)" class="btn btn-danger btn-sm" data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('app.delete') @lang('role.role')" title="@lang('app.delete') @lang('role.role')">
                                                                <i class="fa fa-trash text-white"></i>
                                                            </a>
                                                        @endif
                                                        </div>
                                                    </div>
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
    @can('role-add')
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{ route('admin.role.store') }}" autocomplete="off">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <input type="search" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{old('name')}}"
                        placeholder="@lang('role.role') {{ __('app.name') }}">
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('role') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">@lang('app.close')</button>
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
