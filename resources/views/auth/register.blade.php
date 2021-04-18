<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo_corner.png') }}">

    <link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
</head>
<body>

<div class="main-wrapper" id="app">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pr-md-0">
                                <div class="auth-left-wrapper" style="background-image: url('{{ asset('wisma.jpg') }}')">
                                </div>
                            </div>
                            <div class="col-md-8 pl-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="#" class="noble-ui-logo d-block mb-2" style="color: #f91100;">Red<span>Corner</span></a>
                                    <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
                                    <form class="forms-sample" method="post" action="{{ route('register.proses') }}">
                                        @csrf
                                        <x-form-group id="nama" caption="Nama">
                                            <x-input name="nama" :value="$user->nama ?? ''" required />
                                        </x-form-group>
                                        <x-form-group id="email" caption="Username">
                                            <x-input name="email" :value="$user->email ?? ''" required />
                                        </x-form-group>
                                        <x-form-group id="password" caption="Password">
                                            <x-input name="password" type="password" required />
                                        </x-form-group>
                                        <div class="form-check form-check-flat form-check-primary">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="remember" class="form-check-input">
                                                Remember me
                                            </label>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>

</body>
</html>
