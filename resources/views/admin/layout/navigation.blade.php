@php $user = auth()->user(); @endphp
<div class="sidebar"  data-background-color="white">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item {{activeNav('admin.dashboard')}}">
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
                @can('user-manage')
                <li class="nav-item {{ activeNav('admin.adminUser.*') }}">
                    <a data-toggle="collapse" href="#base">
                        <i class="fas fa-users-cog"></i>
                        <p>Admin</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ openNav(['admin.adminUser.*']) }}" id="base">
                        <ul class="nav nav-collapse">
                            <li class="{{ activeSubNav(['admin.adminUser.*']) }}">
                                <a href="{{ route('admin.adminUser.index') }}">
                                    <span class="sub-item">Admin User</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan


                <li class="nav-item {{ activeNav(['admin.subject.*','admin.exam.*','admin.markDistribution.*']) }}">
                    <a data-toggle="collapse" href="#setup">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <p>Setup</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ openNav(['admin.subject.*','admin.exam.*','admin.markDistribution.*']) }}" id="setup">
                        <ul class="nav nav-collapse">
                            @can('subject-manage')
                            <li class="{{ activeSubNav('admin.subject.*') }}">
                                <a href="{{ route('admin.subject.index') }}">
                                    <span class="sub-item">Subject & Chapter</span>
                                </a>
                            </li>
                            @endcan
                            @can('exam-manage')
                            <li class="{{ activeSubNav('admin.exam.*') }}">
                                <a href="{{ route('admin.exam.index') }}">
                                    <span class="sub-item">Exam/Course</span>
                                </a>
                            </li>
                            @endcan
                            @can('mark-distribution-manage')
                            <li class="{{ activeSubNav('admin.markDistribution.*') }}">
                                <a href="{{ route('admin.markDistribution.index') }}">
                                    <span class="sub-item">Mark Distribution</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>

                @can('question-entry-manage')
                <li class="nav-item {{ activeNav('admin.question.*') }}">
                    <a href="{{ route('admin.question.index') }}">
                        <i class="fa-solid fa-circle-question"></i>
                        <p>Question Entry</p>
                    </a>
                </li>
                @endcan

                @can('question-generate-manage')
                <li class="nav-item {{ activeNav('admin.generateQuestion.*') }}">
                    <a href="{{ route('admin.generateQuestion.index') }}">
                        <i class="fa-solid fa-file-circle-question"></i>
                        <p>Generate Question Paper</p>
                    </a>
                </li>
                @endcan

                @can('question-paper-manage')
                <li class="nav-item {{ activeNav('admin.generatedQues.*') }}">
                    <a href="{{ route('admin.generatedQues.index') }}">
                        <i class="fa-solid fa-clipboard-question"></i>
                        <p>Question Paper</p>
                    </a>
                </li>
                @endcan

                @can('answer-paper-manage')
                <li class="nav-item {{ activeNav('admin.answerPaper.*') }}">
                    <a href="{{ route('admin.answerPaper.index') }}">
                        <i class="fa-solid fa-file-circle-check"></i>
                        <p>Answer Paper</p>
                    </a>
                </li>
                @endcan

                <li class="nav-item {{ activeNav(['admin.role.*','admin.backup.*','admin.visitorInfo.*','admin.permission.*']) }}">
                    <a data-toggle="collapse" href="#settings">
                        <i class="fa-solid fa-gears"></i>
                        <p>Settings</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{openNav(['admin.role.*','admin.backup.*','admin.visitorInfo.*','admin.permission.*'])}}" id="settings">
                        <ul class="nav nav-collapse">
                            @canany('role-manage','permission-manage')
                            <li class="{{ activeSubNav('admin.role.*','admin.permission.*')}}">
                                <a href="{{ route('admin.role.index') }}">
                                    <span class="sub-item">@lang('nav.role-permission')</span>
                                </a>
                            </li>
                            @endcanany
                            @canany('backup-manage')
                            <li class="{{ activeSubNav('admin.backup.*')}}">
                                <a href="{{ route('admin.backup.password') }}">
                                    <span class="sub-item">App Backup</span>
                                </a>
                            </li>
                            @endcanany
                            @canany('visitor-manage')
                            <li class="{{ activeSubNav('admin.visitorInfo.*')}}">
                                <a href="{{ route('admin.visitorInfo.index') }}">
                                    <span class="sub-item">Visitor Info</span>
                                </a>
                            </li>
                            @endcanany
                        </ul>
                    </div>
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
