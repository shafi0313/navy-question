<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Reset Password</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('backend/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['{{ asset("backend/css/fonts.css") }}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/css/azzara.min.css') }}">
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<h3 class="text-center">Reset Password</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session()->has('message'))
                <div class="alert alert-{{session('type')}}">
                    {{session('message')}}
                </div>
            @endif
			<form method="POST" action="{{ route('resetPasswordProcess') }}">
				@csrf
                <input type="hidden" name="email" value="{{$user->email}}">
                <div class="form-group">
                    <label for="passwordsignin" class="placeholder"><b>Password</b></label>
                    <div class="position-relative">
                        <input type="password" name="password" class="form-control" id="passwordsignin"  required autocomplete="new-password">
                        <div class="show-password">
                            <i class="flaticon-interface"></i>
                        </div>
                        @if ($errors->has('password'))
                            <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmpassword" class="placeholder"><b>Confirm Password</b></label>
                    <div class="position-relative">
                        <input  id="confirmpassword" class="form-control" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                        <div class="show-password">
                            <i class="flaticon-interface"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group form-action-d-flex mb-3">
                    <button type="submit" class="btn btn-primary col-md-5 m-auto mt-3 mt-sm-0 fw-bold">Register</button>
                </div>
			</div>
		</form>
	</div>
	<script src="{{ asset('backend/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('backend/js/ready.js') }}"></script>
</body>
</html>
