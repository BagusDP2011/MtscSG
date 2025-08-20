<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Login | MTSC Inventory</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- FOR DEMO PURPOSES ONLY -->
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/inven12.jpg')}}">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
            background: url("{{ asset('assets/img/mtsc-cover.jpg') }}") no-repeat center center fixed;
            background-size: 100% auto;
        }

        .vertical-align-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .auth-box {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.95);
            /* transparansi supaya bg kelihatan */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .auth-box .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-success {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .btn-success:hover {
            background-color: #45a049;
        }

        .form-control {
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .fancy-checkbox span {
            margin-left: 8px;
        }

        .alert {
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="auth-box">
                <div class="content">
                    <div class="header">
                        <h1 class="lead">Inventory Management System</h1>
                    </div>
                    <form class="form-auth-small" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="signin-email" class="control-label sr-only">Email</label>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="signin-email" value="{{ old('email') }}" required placeholder="Email">
                            @if ($errors->has('email'))
                            <br>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong><i class="icon fa fa-ban"></i> Alert!</strong> &nbsp; {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="signin-password" class="control-label sr-only">Password</label>
                            <input type="password" class="form-control" name="password" id="signin-password" value="{{ old('password') }}" placeholder="Password">
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group clearfix">
                            <label class="fancy-checkbox element-left">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>Remember me</span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg btn-block">LOGIN</button>
                    </form><br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</body>

</html>