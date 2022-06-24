@extends('backend.layouts.blank')

@section('content')

<div class="h-100 bg-cover bg-center py-5 d-flex align-items-center" style="background-image: url({{ uploaded_asset(get_setting('admin_login_background')) }})">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-xl-4 mx-auto">
                <div class="card text-left bg-transparent">
                    <div class="absolute-full bg-white opacity-70"></div>
                    <div class="card-body position-relative z-1">
                        <div class="mb-4 text-center">
                            <img src="{{ uploaded_asset(get_setting('system_logo_black')) }}" class="mw-100 mb-4" height="40">
                            <h1 class="h3 text-primary mb-0 border-top text-uppercase pt-3" style="border-color: #fff !important">{{ translate('Welcome') }}</h1>
                            <p class="fs-15 opacity-80">{{ translate('Login to your account.') }}</p>
                        </div>
                        <form class="pad-hor" method="POST" role="form" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label class="mb-1">{{ translate('Email') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ translate('Email') }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="mb-1">{{ translate('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ translate('Password') }}">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="text-left">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span>{{ translate('Remember Me') }}</span>
                                            <span class="aiz-square-check bg-white"></span>
                                        </label>
                                    </div>
                                </div>
                                @if(env('MAIL_USERNAME') != null && env('MAIL_PASSWORD') != null)
                                    <div class="col-sm-6">
                                        <div class="text-right">
                                            <a href="{{ route('password.request') }}" class="text-reset fs-14">{{translate('Forgot password')}} ?</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                {{ translate('Login') }}
                            </button>
                        </form>
                        @if (env("DEMO_MODE") == "On")
                            <div class="mt-4">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>admin@example.com</td>
                                            <td>123456</td>
                                            <td><button class="btn btn-info btn-xs" onclick="autoFill()">{{ translate('Copy') }}</button></td>
                                        </tr>
                                        <tr>
                                            <td>seller@example.com</td>
                                            <td>123456</td>
                                            <td><button class="btn btn-info btn-xs" onclick="autoFillSeller()">{{ translate('Copy') }}</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript">
    function autoFill(){
        $('#email').val('admin@example.com');
        $('#password').val('123456');
    }
    function autoFillSeller(){
        $('#email').val('seller@example.com');
        $('#password').val('123456');
    }
</script>
@endsection
