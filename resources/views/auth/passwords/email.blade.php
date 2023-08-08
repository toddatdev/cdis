@include('layouts.partials.header')
<div class="gray-bg" style="min-height: 100vh">
    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Forgot password</h2>
                    <p>
                        Enter your email address and your password will be reset and emailed to you.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button type="submit"
                                        class="btn btn-primary block full-width m-b">      {{ __('Send Password Reset Link') }}</button>
                                <a href="{{route('login')}}"
                                   class="btn btn-primary block full-width m-b">      {{ __('Back to Login') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright CDIS
            </div>
            <div class="col-md-6 text-right">
                <small>© 2014-{{date('Y')}}</small>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.footer')
