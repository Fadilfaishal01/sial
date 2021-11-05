<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIAL | {{ $title ?? 'Dashboard' }}</title>

        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    </head>
    <body>
        <section class="material-half-bg">
            <div class="cover"></div>
        </section>

        <section class="login-content">
            <div class="logo">
                <h1>SIAL</h1>
            </div>

            <div class="login-box">
                <form class="login-form" action="{{ route('register') }}" method="POST">
                    @csrf
                    <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN UP</h3>
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input class="form-control" name="name" type="text" placeholder="Name" autofocus>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input class="form-control" name="email" type="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input class="form-control" name="password" type="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password Confirmation</label>
                        <input class="form-control" name="password_confirmation" type="password" placeholder="Password Confirmation">
                    </div>
                    <div class="form-group btn-container">
                        <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>Sign Up</button>
                    </div>
                </form>
            </div>
        </section>

        <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
    </body>
</html>
