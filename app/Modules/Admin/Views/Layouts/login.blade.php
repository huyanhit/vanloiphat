<!DOCTYPE html>
<html>
    <head>
        <title>Administrator</title>
        <link rel="stylesheet" id="bootstrap-css" href="{{Request::root()}}/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" id="font-awesome-css" href="{{Request::root()}}/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" id="bootstrap-css" href="{{Request::root()}}/css/admin.css" type="text/css">
    </head>
    <body id="admin-login">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div id="box-error" class="col-md-12">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="card-header">{{ __('Login') }}</div>
                            <div class="card-body">
                                <form method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-right">{{ __('E-Mail Address') }}</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control " name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check text-left">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4 text-right">
                                            <input type="submit" name="submit" class="btn btn-primary" value="Login"/>
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
