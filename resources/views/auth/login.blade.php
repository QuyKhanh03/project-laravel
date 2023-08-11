@extends('auth.layout')
@section('content')
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content" style="width: 600px">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form" style="width: 600px">
                                <div class="text-center mb-3">
                                    <a href="{{ route('fe.home.index') }}"><img
                                            src="{{ asset('templates/client/img/logo/logo.png') }}" alt=""></a>
                                </div>
                                <h4 class="text-center mb-4">Đăng nhập tài khoản của bạn</h4>
                                <form action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Email</strong></label>
                                        <input type="email" name="email" class="form-control" @error('email')  is-invalid
                                               @enderror value="{{ old('email') }}" required autocomplete="email"
                                               autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Mật khẩu</strong></label>
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                        <div class="form-group">
                                            <div class="form-check custom-checkbox ms-1">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Ghi nhớ đăng nhập') }}
                                                </label>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <a href="">Quên mật khẩu?</a>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block"
                                                style="background: #ff5400;border-color: #ff5400">Đăng nhập
                                        </button>

                                    </div>
                                </form>
                                <div class="new-account mt-3 row">
                                    <div class="col">
                                        <p>Bạn chưa có tài khoản ? <a  style="color: #ff5400" href="#">Đăng
                                                Ký</a></p>
                                    </div>
                                    <div class="col flex items-center justify-end  float-end">
                                        <a href="{{ route('google.redirect') }}">
                                            <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" style="margin-left: 3em;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
