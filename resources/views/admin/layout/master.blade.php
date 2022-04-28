<!DOCTYPE html>
<html lang="en">
    @php
    $user = auth()->user();
    @endphp
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title') | {{config('app.name')}}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="../assets/img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('backend/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands", "simple-line-icons"
                ],
                urls: ['{{ asset("backend/css/fonts.min.css" )}}']
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/atlantis.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('backend/css/demo.css') }}">
</head>

<body data-background-color="bg1">
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="purple">
                <a href="{{ route('admin.dashboard') }}" class="logo"> <h4 class="display:4 text-light" style="margin-top: 20px">Company Name</h4>
				</a>
                {{-- <a href="index.html" class="logo">
                    <img src="{{ asset('backend/img/logo.svg') }}" alt="navbar brand" class="navbar-brand">
                </a> --}}
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            @include('admin.layout.header')
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        @include('admin.layout.navigation')
        <!-- End Sidebar -->

        @yield('content')

    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('backend/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('backend/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('backend/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    {{-- <script src="{{ asset('backend/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script> --}}



    <!-- Bootstrap Notify -->
    <script src="{{ asset('backend/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    {{-- jQuery Vector Maps
    <script src="{{ asset('backend/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('backend/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script> --}}

    <!-- Sweet Alert -->
    {{-- <script src="{{ asset('backend/js/plugin/sweetalert/sweetalert.min.js') }}"></script> --}}

    <!-- Atlantis JS -->
    <script src="{{ asset('backend/js/atlantis.min.js') }}"></script>


    {{-- Atlantis DEMO methods, don't include it in your project! --}}
    <script src="{{ asset('backend/js/setting-demo.js') }}"></script>
    <script src="{{ asset('backend/js/demo.js') }}"></script>

    <script>
        $("form").on('submit', function(e){
            $(this).find('button[type="submit"]').attr('disabled', 'disabled');
        });
    </script>

    @include('sweetalert::alert')
	@stack('custom_scripts')
</body>

</html>
