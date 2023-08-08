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
                        <div class="card-body">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group ">
                                    <label for="email"
                                           class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ $email ?? old('email') }}" required autocomplete="email"
                                               autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-md-12">{{ __('Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label for="password-confirm"
                                           class="col-md-12 col-form-label ">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-12 ">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0 mt-2">
                                    <div class="col-md-6 offset-md-4 mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('layouts.partials.footer')
