<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Reset Password</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="../assets/img/icon.ico" type="image/x-icon" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/azzara.min.css') }}">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <h4 class="text-center alert alert-info">Reset Password</h4>

            @if(session()->has('message'))
            <div class="alert alert-{{session('type')}}">
                {{session('message')}}
            </div>
            @endif
            <br>
            @php
            $msg = session('message');
            @endphp
            <h3>Click the active button to set a new password</h3>
        </div>
</body>

</html>
