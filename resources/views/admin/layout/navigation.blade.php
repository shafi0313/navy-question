@php $user = auth()->user(); @endphp
<div class="sidebar"  data-background-color="white">
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
                                <a href="{{ route('admin.myProfile.profile.index') }}">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
            <ul class="nav nav-primary">
                <li class="nav-item {{$m=='dashboard'?'active':''}}">
                    <a href="{{ route('admin.dashboard') }}">
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
                <li class="nav-item {{$m=='admin'?'active submenu':''}}">
                    <a data-toggle="collapse" href="#base">
                        <i class="fas fa-users-cog"></i>
                        <p>Admin</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{$m=='admin'?'show':''}}" id="base">
                        <ul class="nav nav-collapse">
                            <li class="{{$sm=='adminUser'?'activeSub':''}}">
                                <a href="{{ route('admin.adminUser.index') }}">
                                    <span class="sub-item">Admin User</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{$m=='setup'?'active submenu':''}}">
                    <a data-toggle="collapse" href="#setup">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <p>Setup</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{$m=='setup'?'show':''}}" id="setup">
                        <ul class="nav nav-collapse">
                            <li class="{{$sm=='subject'?'activeSub':''}}">
                                <a href="{{ route('admin.subject.index') }}">
                                    <span class="sub-item">Subject & Chapter</span>
                                </a>
                            </li>
                            <li class="{{$sm=='exam'?'activeSub':''}}">
                                <a href="{{ route('admin.exam.index') }}">
                                    <span class="sub-item">Exam/Course</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>



                <li class="nav-item {{$m=='question'?'active':''}}">
                    <a href="{{ route('admin.question.index') }}">
                        <i class="fa-solid fa-circle-question"></i>
                        <p>Question Entry</p>
                    </a>
                </li>

                <li class="nav-item {{$m=='generateQuestion'?'active':''}}">
                    <a href="{{ route('admin.generateQuestion.index') }}">
                        <i class="fa-solid fa-file-circle-question"></i>
                        <p>Generate Question Paper</p>
                    </a>
                </li>

                <li class="nav-item {{$m=='generatedQues'?'active':''}}">
                    <a href="{{ route('admin.generatedQues.index') }}">
                        <i class="fa-solid fa-clipboard-question"></i>
                        <p>Question Paper</p>
                    </a>
                </li>

                <li class="nav-item {{$m=='answerPaper'?'active':''}}">
                    <a href="{{ route('admin.answerPaper.index') }}">
                        <i class="fa-solid fa-file-circle-check"></i>
                        <p>Answer Paper</p>
                    </a>
                </li>

                <li class="nav-item {{$m=='backup'?'active':''}}">
                    <a href="{{ route('admin.backup.password') }}">
                        <i class="fas fa-database"></i>
                        <p>App Backup</p>
                    </a>
                </li>

                <li class="nav-item {{$m=='visitor'?'active':''}}">
                    <a href="{{ route('admin.visitorInfo.index') }}">
                        <i class="fas fa-user-secret"></i>
                        <p>Visitor Info</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>


{{--
                <li class="nav-item">
                    <a href="widgets.html">
                        <i class="fas fa-desktop"></i>
                        <p>Widgets</p>
                        <span class="badge badge-success">4</span>
                    </a>
                </li> --}}


                {{-- <li class="nav-item">
                    <a data-toggle="collapse" href="#submenu">
                        <i class="fas fa-bars"></i>
                        <p>Menu Levels</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="submenu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-toggle="collapse" href="#subnav1">
                                    <span class="sub-item">Level 1</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav1">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#subnav2">
                                    <span class="sub-item">Level 1</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav2">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="#">
                                                <span class="sub-item">Level 2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Level 1</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
