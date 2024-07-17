@php $user = auth()->user(); @endphp
<div class="sidebar" data-background-color="white">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            {{-- <div class="user">
                @if ($user->email == devAdminEmail())
                    @php $profileImg =  asset('uploads/images/users/shafi.jpg') @endphp
                @elseif($user->images == null)
                    @php $profileImg =  asset('uploads/images/users/company_logo.jpg') @endphp
                @else
                    @php $profileImg =  asset('uploads/images/users/'.$user->image) @endphp
                @endif
                <div class="avatar-sm float-left mr-2">
                    <img src="{{$profileImg}}" alt="..." class="avatar-img rounded-circle">
                </div>

                <div class="info">
                    <a data-toggle="collapse" href="#myProfile" aria-expanded="true">
                        <span>
                            {{ $user->name }}
                            <span class="user-level">{{ $user->designation }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse {{$m=='myProfile'?'show':''}} in" id="myProfile">
                        <ul class="nav">
                            <li class="{{$sm=='profile'?'activeSub':''}}">
                                <a href="{{ route('user.myProfile.profile.index') }}">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
            <ul class="nav nav-primary">
                <li class="nav-item {{ $m == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>

                <li class="nav-item {{ $m == 'generatedQues' ? 'active' : '' }}">
                    <a href="{{ route('user.generated_question.index') }}">
                        <i class="fa-solid fa-book-atlas"></i>
                        <p>Exam & Question</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
