@extends('admin.layout.master')
@section('title', 'Admin User')
@section('content')
@php $m='admin'; $sm='adminUser'; $ssm=''; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('admin.adminUser.index') }}">Admin User</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Edit</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Admin User</div>
                        </div>
                        <form action="{{ route('admin.adminUser.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Permissions <span class="t_r">*</span></label>
                                            <select class="form-control" name="permission">
                                                <option>No Login Permission</option>
                                                <option value="1" {{$user->accessPermission->role_id == 1 ? 'selected' : ''}}>Admin</option>
                                                <option value="2" {{$user->accessPermission->role_id == 2 ? 'selected' : ''}}>Creator</option>
                                                <option value="3" {{$user->accessPermission->role_id == 3 ? 'selected' : ''}}>Editor</option>
                                                <option value="4" {{$user->accessPermission->role_id == 4 ? 'selected' : ''}}>Viewer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name <span class="t_r">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            @if ($errors->has('name'))
                                                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="designation">Designation </label>
                                            <input type="text" name="designation" class="form-control" value="{{ $user->designation }}">
                                            @if ($errors->has('designation'))
                                                <div class="alert alert-danger">{{ $errors->first('designation') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email address <span class="t_r">*</span></label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required readonly>
                                            @if ($errors->has('email'))
                                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone <span class="t_r">*</span></label>
                                            <input type="text" name="phone" class="form-control" oninput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" class="form-control" value="{{ $user->phone }}" required>
                                            @if ($errors->has('phone'))
                                                <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="d_o_b">Date of birth <span class="t_r">*</span></label>
                                            <input type="date" name="d_o_b" class="form-control"  value="{{ $user->d_o_b }}" required >
                                            @if ($errors->has('d_o_b'))
                                                <div class="alert alert-danger">{{ $errors->first('d_o_b') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image">Image </label>
                                            <input type="file" name="image" class="form-control">
                                            @if ($errors->has('image'))
                                                <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image">Image </label>
                                            <input type="hidden" name="old_image" value="{{ asset('uploads/images/users/'.$user->image) }}">
                                            <img src="{{ asset('uploads/images/users/'.$user->image) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Address <span class="t_r">*</span></label>
                                            <textarea name="address" class="form-control" id="comment" rows="2" required>
                                                {{ $user->address }}
                                            </textarea>
                                            @if ($errors->has('address'))
                                                <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="passwordsignin">Password <span class="t_r">*</span></label>
                                            <input type="password" name="password" class="form-control" id="passwordsignin" autocomplete="new-password" required>
                                            @if ($errors->has('password'))
                                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirmpassword">Confirm Password <span class="t_r">*</span></label>
                                            <input class="form-control" type="password" name="password_confirmation" autocomplete="new-password" required>
                                            @if ($errors->has('password'))
                                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center card-action">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.footer')
</div>

@push('custom_scripts')
@endpush
@endsection

