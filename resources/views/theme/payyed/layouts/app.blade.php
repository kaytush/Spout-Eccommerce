<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <link href="/{{$basic->theme}}/images/favicon.png" rel="icon" />
    <title>{{ config('app.name', $basic->sitename) }} | @yield('title', config('app.name'))</title>
    <meta name="description" content="{{$basic->description}}">
    <meta name="author" content="giftbills.com">

    <!-- Web Fonts
    ============================================= -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i' type='text/css'>

    <!-- Stylesheet
    ============================================= -->
    <link rel="stylesheet" type="text/css" href="/{{$basic->theme}}/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/{{$basic->theme}}/vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="/{{$basic->theme}}/vendor/owl.carousel/assets/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="/{{$basic->theme}}/vendor/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="/{{$basic->theme}}/vendor/bootstrap-select/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="/{{$basic->theme}}/vendor/currency-flags/css/currency-flags.min.css" />
    <link rel="stylesheet" type="text/css" href="/{{$basic->theme}}/vendor/currency-flags/css/isp-providers.min.css" />
    <link rel="stylesheet" type="text/css" href="/{{$basic->theme}}/css/stylesheet.css" />

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
    <!-- CSS Toast Alert -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <style>
        .spinner {
            width: 40px;
            height: 40px;

            position: relative;
            margin: 0px auto;
        }

        .double-bounce1, .double-bounce2 {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #FFF;
            opacity: 0.6;
            position: absolute;
            top: 0;
            left: 0;

            -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
            animation: sk-bounce 2.0s infinite ease-in-out;
        }

        .double-bounce2 {
            -webkit-animation-delay: -1.0s;
            animation-delay: -1.0s;
        }

        @-webkit-keyframes sk-bounce {
            0%, 100% { -webkit-transform: scale(0.0) }
            50% { -webkit-transform: scale(1.0) }
        }

        @keyframes sk-bounce {
        0%, 100% {
            transform: scale(0.0);
            -webkit-transform: scale(0.0);
        } 50% {
            transform: scale(1.0);
            -webkit-transform: scale(1.0);
        }
        }
    </style>

</head>
<body>

<!-- Preloader -->
{{-- <div id="preloader">
  <div data-loader="dual-ring"></div>
</div> --}}
<!-- Preloader End -->

<!-- Document Wrapper
============================================= -->
<div id="main-wrapper">

  <!-- Header
  ============================================= -->
  <header id="header">
    <div class="container">
      <div class="header-row">
        <div class="header-column justify-content-start">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav"> <span></span> <span></span> <span></span> </button>
          <!-- Logo
          ============================= -->
          <div class="logo"> <a class="d-flex" href="/" title="{{$basic->sitename}}"><img src="/{{$basic->theme}}/images/logo.png" width="121" height="33" alt="{{$basic->sitename}}" /></a> </div>
          <!-- Logo end -->
          <!-- Collapse Button
          ============================== -->

          <!-- Collapse Button end -->

          <!-- Primary Navigation
          ============================== -->
          <nav class="primary-menu navbar navbar-expand-lg">
            <div id="header-nav" class="collapse navbar-collapse">
              <ul class="navbar-nav mr-auto">
                @auth
                    <li @if(Request::url() == route('dashboard')) class="active" @endif><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li @if(Request::url() == route('airtime')) class="active" @endif><a href="{{route('airtime')}}" data-turbo="false">Airtime</a></li>
                    <li @if(Request::url() == route('internet')) class="active" @endif><a href="{{route('internet')}}" data-turbo="false">Internet Data</a></li>
                    <li class="dropdown"> <a class="dropdown-toggle" href="javascript:void(0);">Bills</a>
                        <ul class="dropdown-menu">
                            <li @if(Request::url() == route('tv')) class="active" @endif><a class="dropdown-item" href="{{route('tv')}}" data-turbo="false">Cable TV</a></li>
                            {{-- <li @if(Request::url() == route('electricity')) class="active" @endif><a class="dropdown-item" href="{{route('electricity')}}" data-turbo="false">Electricity</a></li> --}}
                            {{-- <li @if(Request::url() == route('betting')) class="active" @endif><a class="dropdown-item" href="{{route('betting')}}" data-turbo="false">Betting</a></li> --}}
                            {{-- <li @if(Request::url() == route('dashboard')) class="active" @endif><a class="dropdown-item" href="{{route('dashboard')}}">Convert Airtime</a></li> --}}
                            {{-- <li @if(Request::url() == route('dashboard')) class="active" @endif><a class="dropdown-item" href="{{route('dashboard')}}">Educational</a></li> --}}
                        </ul>
                    </li>
                    <li><a href="{{route('fund')}}">Fund Wallet</a></li>
                    <li><a href="{{route('fund-transfer')}}" data-turbo="false">Transfer</a></li>
                    <li @if(Request::url() == route('transactions')) class="active" @endif><a href="{{route('transactions')}}">Trasnactions</a></li>
                @else
                    <li @if(Request::url() == route('main')) class="active" @endif><a href="{{route('main')}}">Home</a></li>
                    <li @if(Request::url() == route('about')) class="active" @endif><a href="{{route('about')}}">About</a></li>
                    <li @if(Request::url() == route('main')) class="active" @endif><a href="{{route('main')}}">Pricing</a></li>
                    <li @if(Request::url() == route('help')) class="active" @endif><a href="{{route('help')}}">Help</a></li>
                    <li @if(Request::url() == route('contact')) class="active" @endif><a href="{{route('contact')}}">Contact Us</a></li>
                @endauth
              </ul>
            </div>
          </nav>
          <!-- Primary Navigation end -->
        </div>
        <div class="header-column justify-content-end">
          <!-- Login & Signup Link
          ============================== -->
          <nav class="login-signup navbar navbar-expand">
            <ul class="navbar-nav">
                @auth
                    <li class="dropdown language"> <a class="dropdown-toggle" href="javascript:void(0);">En</a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:void(0);">English</a></li>
                        </ul>
                    </li>
                    <li class="dropdown profile ml-2">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                            @if(file_exists(auth()->user()->image))
                                <img class="rounded-circle" src="{{url(auth()->user()->image)}}" width="40px" height="40px" alt="{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}">
                            @else
                                <img class="rounded-circle" src="{{url('assets/images/profile.png')}}" width="40px" height="40px" alt="{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}">
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li class="text-center text-3 py-2">Hi, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</li>
                            <li class="dropdown-divider mx-n3"></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-home"></i>Dashboard</a> </li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user"></i>My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('account-settings') }}"><i class="fas fa-shield-alt"></i>Security</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="fas fa-users"></i>Referral</a></li>
                            <li class="dropdown-divider mx-n3"></li>
                            <li><a class="dropdown-item" href="{{ route('help') }}"><i class="fas fa-life-ring"></i>Need Help?</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').requestSubmit();"><i class="fas fa-sign-out-alt"></i>Sign Out</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Login</a> </li>
                    <li class="align-items-center h-auto ml-sm-3"><a class="btn btn-primary" href="{{ route('register') }}">Sign Up</a></li>
                @endauth
            </ul>
          </nav>
          <!-- Login & Signup Link end -->
        </div>
      </div>
    </div>
  </header>
  <!-- Header End -->

  <!-- Content
  ============================================= -->

    @yield('content')


  <!-- Content end -->

  <!-- Footer
  ============================================= -->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg d-lg-flex align-items-center">
          <ul class="nav justify-content-center justify-content-lg-start text-3">
            <li class="nav-item"> <a class="nav-link active" href="{{route('about')}}">About Us</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('help')}}">Support</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('help')}}">Help</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('contact')}}">Contact Us</a></li>
          </ul>
        </div>
        <div class="col-lg d-lg-flex justify-content-lg-end mt-3 mt-lg-0">
          <ul class="social-icons justify-content-center">
            <li class="social-icons-facebook"><a data-toggle="tooltip" href="{{$basic->facebook}}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
            <li class="social-icons-twitter"><a data-toggle="tooltip" href="{{$basic->twitter}}" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
            <li class="social-icons-linkedin"><a data-toggle="tooltip" href="{{$basic->telegram}}" target="_blank" title="Telegram"><i class="fab fa-telegram"></i></a></li>
            <li class="social-icons-linkedin"><a data-toggle="tooltip" href="{{$basic->linkedin}}" target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a></li>
            <li class="social-icons-youtube"><a data-toggle="tooltip" href="{{$basic->youtube}}" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a></li>
            <li class="social-icons-youtube"><a data-toggle="tooltip" href="{{$basic->instagram}}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="footer-copyright pt-3 pt-lg-2 mt-2">
        <div class="row">
          <div class="col-lg">
            <p class="text-center text-lg-left mb-2 mb-lg-0">Copyright &copy; 2022 <a href="index.html#">{{$basic->sitename}}</a>. All Rights Reserved.</p>
          </div>
          <div class="col-lg d-lg-flex align-items-center justify-content-lg-end">
            <ul class="nav justify-content-center">
              <li class="nav-item"> <a class="nav-link active" href="index.html#">Security</a></li>
              <li class="nav-item"> <a class="nav-link" href="index.html#">Terms</a></li>
              <li class="nav-item"> <a class="nav-link" href="index.html#">Privacy</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer end -->

</div>
<!-- Document Wrapper end -->

<!-- Back to Top
============================================= -->
<a id="back-to-top" data-toggle="tooltip" title="Back to Top" href="javascript:void(0)"><i class="fa fa-chevron-up"></i></a>

<!-- Video Modal
============================================= -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content bg-transparent border-0">
      <button type="button" class="close text-white opacity-10 ml-auto mr-n3 font-weight-400" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body p-0">
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" id="video" allow="autoplay"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Video Modal end -->

    @yield('script')
    @yield('js')
    <script>
      @if(Session::has('success'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.success("{{ session('success') }}");
      @endif

      @if(Session::has('message'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.success("{{ session('message') }}");
      @endif

      @if(Session::has('error'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.error("{{ session('error') }}");
      @endif

      @if(Session::has('info'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.info("{{ session('info') }}");
      @endif

      @if(Session::has('warning'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.warning("{{ session('warning') }}");
      @endif
    </script>

    {{-- laoding state start --}}
    <script>
        function globalLoading() {
            document.getElementById().innerHTML = "<div class='spinner-border text-primary' role='status'></div>";
        };
        function loadingBounce() {
            document.getElementById("show").innerHTML = "<div class='spinner'><div class='double-bounce1'></div><div class='double-bounce2'></div></div>";
            document.getElementById("show").disabled = true;
        };
        function loadingPrimary() {
            document.getElementById("show").innerHTML = "<div class='spinner-border text-primary' role='status'></div>";
            document.getElementById("show").disabled = true;
        };
        function loadingSuceess() {
            document.getElementById("show").innerHTML = "<div class='spinner-border text-success' role='status'></div>";
            document.getElementById("show").disabled = true;
        };
    </script>
    {{-- laoding state end --}}

    <!-- Script -->
    <script src="/{{$basic->theme}}/vendor/jquery/jquery.min.js"></script>
    <script src="/{{$basic->theme}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/{{$basic->theme}}/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="/{{$basic->theme}}/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="/{{$basic->theme}}/js/theme.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    <script type="text/javascript">
        var Clipboard = new ClipboardJS('.btn');
    </script>

    @stack('modals')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.4/dist/livewire-turbolinks.js" data-turbolinks-eval="false" data-turbo-eval="false"></script>
</body>

</html>
