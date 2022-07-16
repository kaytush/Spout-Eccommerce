<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="{{$basic->sitename}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{$basic->sitename}}">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Page Title  -->
    <title>{{ config('app.name', $basic->sitename) }} | @yield('title', config('app.name'))</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/dashlite.css?ver=2.2.0') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('dash/assets/css/theme.css?ver=2.2.0') }}">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="{{ route('adminLogin') }}" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="{{ asset('assets/images/logo_white.png') }}" srcset="{{ asset('assets/images/logo_white.png 2x') }}" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="{{ asset('logo.png') }}" srcset="{{ asset('logo.png 2x') }}" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Sign-In</h4>
                                        <div class="nk-block-des">
                                            <p>Access the {{$basic->sitename}} Control System.</p>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('adminLoginPost') }}" method="post">
                                    {!! csrf_field() !!}
                                    @if(\Session::get('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ \Session::get('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            </button>
                                        </div>
                                        @endif
                                        {{ \Session::forget('success') }}
                                        @if(\Session::get('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ \Session::get('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            </button>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Email</label>
                                        </div>
                                        <input type="email" class="form-control form-control-lg" id="default-01" name="email" placeholder="Email" required="required">
                                        @if ($errors->has('email'))
                                            <span class="help-block font-red-mint">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required="required">
                                            @if ($errors->has('password'))
                                                <span class="help-block font-red-mint">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6 order-lg-last">
                                    <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Terms & Condition</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Privacy Policy</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Help</a>
                                        </li>
                                        <li class="nav-item dropup">
                                            <a class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                <ul class="language-list">
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="{{ asset('dash/images/flags/english.png') }}" alt="" class="language-flag">
                                                            <span class="language-name">English</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="{{ asset('dash/images/flags/spanish.png') }}" alt="" class="language-flag">
                                                            <span class="language-name">Español</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="{{ asset('dash/images/flags/french.png') }}" alt="" class="language-flag">
                                                            <span class="language-name">Français</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="{{ asset('dash/images/flags/turkey.png') }}" alt="" class="language-flag">
                                                            <span class="language-name">Türkçe</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">&copy; {{date('Y')}} {{$basic->sitename}}. All Rights Reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ asset('dash/assets/js/bundle.js?ver=2.2.0') }}"></script>
    <script src="{{ asset('dash/assets/js/scripts.js?ver=2.2.0') }}"></script>

</body>
</html>
