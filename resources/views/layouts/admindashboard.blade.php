<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="{{$basic->sitename}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{$basic->sitename}}">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Page Title  -->
    <title>{{ config('app.name', $basic->sitename) }} | @yield('title', config('app.name'))</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/dashlite.css?ver=2.2.0') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('dash/assets/css/theme.css?ver=2.2.0') }}">
</head>

<body class="nk-body npc-invest bg-lighter ">
    <div class="nk-app-root">
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <div class="nk-header nk-header-fluid is-theme">
                <div class="container-xl wide-xl">
                    <div class="nk-header-wrap">
                        <div class="nk-menu-trigger mr-sm-2 d-lg-none">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
                        </div>
                        <div class="nk-header-brand">
                            <a href="{{ route('admin.dashboard') }}" class="logo-link">
                                <img class="logo-light logo-img" src="{{ asset('assets/images/logo_white.png') }}" srcset="{{ asset('assets/images/logo_white.png 2x') }}" alt="logo">
                                <img class="logo-dark logo-img" src="{{ asset('assets/images/logo.png') }}" srcset="{{ asset('assets/images/logo.png 2x') }}" alt="logo-dark">
                            </a>
                        </div><!-- .nk-header-brand -->
                        <div class="nk-header-menu" data-content="headerNav">
                            <div class="nk-header-mobile">
                                <div class="nk-header-brand">
                                    <a href="{{ route('admin.dashboard') }}" class="logo-link">
                                        <img class="logo-light logo-img" src="{{ asset('assets/images/logo_white.png') }}" srcset="{{ asset('assets/images/logo_white.png 2x') }}" alt="logo">
                                        <img class="logo-dark logo-img" src="{{ asset('assets/images/logo.png') }}" srcset="{{ asset('assets/images/logo.png 2x') }}" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-menu-trigger mr-n2">
                                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                                </div>
                            </div>
                            <ul class="nk-menu nk-menu-main ui-s2">
                                <li class="nk-menu-item has-sub">
                                    <a href="{{ route('admin.dashboard') }}" class="nk-menu-link">
                                        <span class="nk-menu-text">Dashboards</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Services</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('services') }}" class="nk-menu-link"><span class="nk-menu-text">Our Services</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('service-cat') }}" class="nk-menu-link"><span class="nk-menu-text">Service Category</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Orders</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{route('order-requests')}}" class="nk-menu-link"><span class="nk-menu-text">Service Requests</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('orders-in-progress')}}" class="nk-menu-link"><span class="nk-menu-text">Service in Progress</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('completed-orders')}}" class="nk-menu-link"><span class="nk-menu-text">Service Completed</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Histories</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{route('bill-history')}}" class="nk-menu-link"><span class="nk-menu-text">Bill Hisotry</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('deposit-history')}}" class="nk-menu-link"><span class="nk-menu-text">Deposit Hisotry</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('transaction-history')}}" class="nk-menu-link"><span class="nk-menu-text">Transaction Hisotry</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('withdrawal-history')}}" class="nk-menu-link"><span class="nk-menu-text">Withdrawal Hisotry</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('convert-airtime-history')}}" class="nk-menu-link"><span class="nk-menu-text">Convert Airtime Hisotry</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Accounts</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('clients') }}" class="nk-menu-link"><span class="nk-menu-text">Clients</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('staffs') }}" class="nk-menu-link"><span class="nk-menu-text">Staffs</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('manage.subscribers') }}" class="nk-menu-link"><span class="nk-menu-text">Subscribers</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('send.mail.subscriber') }}" class="nk-menu-link"><span class="nk-menu-text">Email Broadcast</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Frontend</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item  has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                <span class="nk-menu-text">Main</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('home-header') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Home Header</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('home-privacy') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Privacy</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('home-terms') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Terms & Cond.</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                            </ul><!-- .nk-menu-sub -->
                                        </li>
                                        <li class="nk-menu-item  has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                <span class="nk-menu-text">About</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('about-sec-one') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Section One</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('about-sec-two') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Section Two</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                            </ul><!-- .nk-menu-sub -->
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('services') }}" class="nk-menu-link"><span class="nk-menu-text">Services</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('teams') }}" class="nk-menu-link"><span class="nk-menu-text">Teams</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('partners') }}" class="nk-menu-link"><span class="nk-menu-text">Partners</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('counters') }}" class="nk-menu-link"><span class="nk-menu-text">Counters</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('faqs') }}" class="nk-menu-link"><span class="nk-menu-text">FAQs</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('testimonials') }}" class="nk-menu-link"><span class="nk-menu-text">Testimonials</span></a>
                                        </li>
                                        <li class="nk-menu-item  has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                <span class="nk-menu-text">Blog</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('blog-cat') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Blog Category</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('blog-list') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Blog List</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('blog-new') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">New Blog Post</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                                {{-- <li class="nk-menu-item">
                                                    <a href="{{ route('payment-settings') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Blog Import</span>
                                                    </a>
                                                </li><!-- .nk-menu-item --> --}}
                                            </ul><!-- .nk-menu-sub -->
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Settings</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('settings') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">System Settings</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('email.template') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">Email Template</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('payment-settings') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">Payment Settings</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('subplan') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">Subscription Plans</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('sms-settings') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">SMS Route Config</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('state') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">State Settings</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-header-menu -->
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                <li class="dropdown user-dropdown order-sm-first">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <div class="user-toggle">
                                            <div class="user-avatar sm">
                                                <em class="icon ni ni-user-alt"></em>
                                            </div>
                                            @php
                                                $greet = date('A', strtotime($time));
                                            @endphp
                                            <div class="user-info d-none d-xl-block">
                                                <div class="user-status @if($greet == 'PM')user-status-unverified @endif">@if($greet == 'AM')Good Morning @else Good Evening @endif</div>
                                                <div class="user-name dropdown-indicator">{{ auth()->guard('admin')->user()->username }}</div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1 is-light">
                                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                            <div class="user-card">
                                                <div class="user-avatar">
                                                    @if(file_exists(auth()->guard('admin')->user()->image))
                                                        <img src="{{url(auth()->guard('admin')->user()->image)}}" alt="">
                                                    @else
                                                        <img src="{{url('assets/images/profile.png')}}" alt="">
                                                    @endif
                                                </div>
                                                <div class="user-info">
                                                    <span class="lead-text">{{ auth()->guard('admin')->user()->name }}</span>
                                                    <span class="sub-text">{{ auth()->guard('admin')->user()->email }}</span>
                                                </div>
                                                <div class="user-action">
                                                    <a class="btn btn-icon mr-n2" href="{{ route('profile') }}"><em class="icon ni ni-setting"></em></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li><a href="{{ route('profile') }}"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                                <li><a href="{{ route('security-settings') }}"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                                <li><a href="{{ route('account-activity') }}"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                            </ul>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li><a href="{{ route('adminLogout') }}"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li><!-- .dropdown -->
                                <li class="hide-mb-sm"><a href="{{ route('adminLogout') }}" class="nk-quick-nav-icon"><em class="icon ni ni-signout"></em></a></li>
                            </ul><!-- .nk-quick-nav -->
                        </div><!-- .nk-header-tools -->
                    </div><!-- .nk-header-wrap -->
                </div><!-- .container-fliud -->
            </div>
            <!-- main header @e -->

            @yield('content')

            <!-- footer @s -->
            <div class="nk-footer nk-footer-fluid bg-lighter">
                <div class="container-xl">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright"> &copy; {{date('Y')}} <a href="{{url('/')}}">{{$basic->sitename}}</a>
                        </div>
                        <div class="nk-footer-links">
                            <ul class="nav nav-sm">
                                <li class="nav-item"><a class="nav-link" href="#">Terms</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Privacy</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer @e -->
        </div>
        <!-- wrap @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ asset('dash/assets/js/bundle.js?ver=2.2.0') }}"></script>
    <script src="{{ asset('dash/assets/js/scripts.js?ver=2.2.0') }}"></script>
    <script src="{{ asset('dash/assets/js/charts/gd-invest.js?ver=2.2.0') }}"></script>
    <link rel="stylesheet" href="{{ asset('dash/assets/css/editors/summernote.css?ver=2.2.0') }}">
    <script src="{{ asset('dash/assets/js/libs/editors/summernote.js?ver=2.2.0') }}"></script>
    <script src="{{ asset('dash/assets/js/editors.js?ver=2.2.0') }}"></script>
    <script src="{{ asset('dash/assets/js/apps/chats.js?ver=2.2.0') }}"></script>

@yield('js')
@if ($errors->has('name'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("name") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('username'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("username") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('email'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("email") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('phone'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("phone") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('role'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("role") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('icon'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("icon") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('title'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("title") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('value'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("value") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('subvalue'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("subvalue") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if ($errors->has('status'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ $errors->first("status") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if (session('success'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ session("success") }}', 'success', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if (session('alert'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ session("alert") }}', 'info', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if (session('error'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ session("error") }}', 'error', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if (session('warning'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ session("warning") }}', 'warning', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
@if (session('message'))
    <script>
        (function(NioApp, $){
            'use strict';
            // Example Trigger
            $(function (){
                toastr.clear();
                NioApp.Toast('{{ session("message") }}', 'success', {position: 'top-center'});
            });
        })(NioApp, jQuery);
    </script>
@endif
</body>

</html>
