@extends('admin.layout.master')
@section('title', 'Dashboard')
@section('content')
@php $m='myProfile'; $sm='profile'; $ssm=''; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('admin.adminUser.index') }}">Admin User</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        <div class="card-header" style="background-image: url('{{ asset("../backend/img/blogpost.jpg") }}')">
                            <div class="profile-picture">
                                <div class="avatar avatar-xxl">
                                    <img src="{{ profileImg($user->email, $user->image) }}" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile text-center">
                                <div class="name">Name: <b>{{ $user->name }}</b></div>
                                <div class="job">Designation: <b>{{ $user->designation }}</b></div>
                                {{-- <div class="desc">{{ \Carbon\Carbon::parse($user->d_o_b)->age }}</div> --}}
                                <div class="job">Email: <b>{{ $user->email }}</b></div>
                                <div class="job">Permission: <b>{{ permissionText($user->permission) }}</b></div>
                                <div class="job">Age: <b>{{ ageWithDays($user->d_o_b) }}</b></div>
                                <div class="job">{{ $user->address }}</div>
                                {{-- <div class="social-media">
                                    <a class="btn btn-info btn-twitter btn-sm btn-link" href="#">
                                        <span class="btn-label just-icon"><i class="flaticon-twitter"></i> </span>
                                    </a>
                                    <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                        <span class="btn-label just-icon"><i class="flaticon-google-plus"></i> </span>
                                    </a>
                                    <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#">
                                        <span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span>
                                    </a>
                                    <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                        <span class="btn-label just-icon"><i class="flaticon-dribbble"></i> </span>
                                    </a>
                                </div> --}}
                                <div class="view-profile">
                                    <a href="#" class="btn btn-secondary btn-block"></a>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-footer">
                            <div class="row user-stats text-center">
                                <div class="col">
                                    <div class="number">125</div>
                                    <div class="title">Post</div>
                                </div>
                                <div class="col">
                                    <div class="number">25K</div>
                                    <div class="title">Followers</div>
                                </div>
                                <div class="col">
                                    <div class="number">134</div>
                                    <div class="title">Following</div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">My Profile</div>
                        </div>
                        <form action="{{ route('admin.myProfile.profile.update') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name <span class="t_r">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
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
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
                                            @if ($errors->has('email'))
                                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone <span class="t_r">*</span></label>
                                            <input type="text" name="phone" oninput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" class="form-control" value="{{ $user->phone }}">
                                            @if ($errors->has('phone'))
                                                <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="d_o_b">Date of birth <span class="t_r">*</span></label>
                                            <input type="date" name="d_o_b" class="form-control" id="d_o_b" value="{{ $user->d_o_b }}">
                                            @if ($errors->has('d_o_b'))
                                                <div class="alert alert-danger">{{ $errors->first('d_o_b') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="passwordsignin">Password</label>
                                            <input type="password" name="password" class="form-control" id="passwordsignin" autocomplete="new-password">
                                            @if ($errors->has('password'))
                                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirmpassword">Confirm Password</label>
                                            <input class="form-control" type="password" name="password_confirmation" autocomplete="new-password">
                                            @if ($errors->has('password'))
                                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="comment">Address</label>
                                            <textarea name="address" class="form-control" rows="5">
                                                {{ $user->address }}
                                            </textarea>
                                            @if ($errors->has('address'))
                                            <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center card-action">
                                <button type="submit" class="btn btn-{{$layout->submit_btn??'primary'}}">Submit</button>
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

