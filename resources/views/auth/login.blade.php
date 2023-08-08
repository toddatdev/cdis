<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CDIS Dashbaord</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>
<body>
<div class="gray-bg"
     style="min-height: 100%;
    background: url(../img/bg-login.jpg) center center;
    background-color: rgba(0,0,0, .4 );
    background-blend-mode: multiply;
    background-size: 100%;
    background-position: bottom;">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div class="card-body bg-white rounded mt-5">
            <span><img class="img img-fluid mt-4 mb-2" src="img/login-logo.png" alt=""></span>
            <h3>Welcome to CDIS</h3>
            <form method="POST" action="{{ route('login', $type ?? '') }}">
                @csrf
                <div class="form-group text-left">
                    {{-- <input type="email" class="form-control" placeholder="Username" required=""> --}}
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group text-left">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                @if (Route::has('password.request'))
                    <a class="" href="{{ route('password.request') }}">
                        <small>{{ __('Forgot Your Password?') }}</small>
                    </a>
                @endif
            </form>
        </div>
    </div>
</div>
</body>

