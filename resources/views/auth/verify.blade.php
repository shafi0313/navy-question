<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Email Varification</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="../assets/img/icon.ico" type="image/x-icon" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/azzara.min.css') }}">
</head>
<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <h4 class="text-center alert alert-info">Email Varification</h4>
            @if(session()->has('message'))
            <div class="alert alert-{{session('type')}}">
                {{session('message')}}
            </div>
            @endif
            <br>
            @php
            $msg = session('message');
            @endphp
            @if ($msg != 'Invalid email')
            <h3>Check your email and active your account</h3>
            @endif

            <a class="btn btn-info" href="#" id="resend">Resend</a>
            <form method="POST" action="{{ route('verifyResend') }}" id="form" style="display: none">
                @csrf
                <div class="login-form">
                    <div class="form-group">
                        <label for="email" class="placeholder"><b>Email</b></label>
                        <input class="form-control" id="email" type="email" name="email" :value="old('email')" required>
                    </div>
                </div>
                <div class="row form-action">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Submit</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    <script src="{{ asset('backend/js/core/jquery.3.2.1.min.js') }}"></script>
    <script>
        $("#resend").click(function () {
            $("#form").fadeIn();
        })
    </script>
</body>

</html>
