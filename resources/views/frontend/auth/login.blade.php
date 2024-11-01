<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ __('Login') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/adminlte.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/adminlte-variable.min.css">
    <link rel="stylesheet" href="{{ asset('css/zakirsoft.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('users.login') }}" class="d-block">
                <div class="auth-logo">
                    <img src="{{ $setting->logo_image_url }}" alt="logo">
                </div>
            </a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('sign_in_to_start_your_session') }}</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}"
                            placeholder="{{ __('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="{{ __('password') }}" value="">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    {{ __('remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('sign_in') }}<i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="#">{{ __('i_forgot_my_password') }}</a>
                </p>
                <hr>
                @if (config('zakirsoft.google_login_active') && config('zakirsoft.google_client_id') && config('zakirsoft.google_client_secret'))
                    <p class="mb-1 d-inline">
                        <a class="text-dark" href="{{ route('social-login', 'google') }}">{{ __('Google') }}</a>
                    </p> |
                @endif
                @if (config('zakirsoft.facebook_active') && config('zakirsoft.facebook_client_id') && config('zakirsoft.facebook_client_secret'))
                    <p class="mb-1 d-inline">
                        <a class="text-dark" href="{{ route('social-login', 'facebook') }}">{{ __('Facebook') }}</a>
                    </p> |
                @endif
                @if (config('zakirsoft.twitter_active') && config('zakirsoft.twitter_client_id') && config('zakirsoft.twitter_client_secret'))
                    <p class="mb-1 d-inline">
                        <a class="text-dark" href="{{ route('social-login', 'twitter') }}">{{ __('Twitter') }}</a>
                    </p> |
                @endif
                @if (config('zakirsoft.linkedin_active') && config('zakirsoft.linkedin_client_id') && config('zakirsoft.linkedin_client_secret'))
                    <p class="mb-1 d-inline">
                        <a class="text-dark" href="{{ route('social-login', 'linkedin') }}">{{ __('Linkedin') }}</a>
                    </p> |
                @endif
                @if (config('zakirsoft.github_active') && config('zakirsoft.github_client_id') && config('zakirsoft.github_client_secret'))
                    <p class="mb-1 d-inline">
                        <a class="text-dark" href="{{ route('social-login', 'github') }}">{{ __('Github') }}</a>
                    </p>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('backend') }}/dist/js/adminlte.min.js"></script>

</body>

</html>
