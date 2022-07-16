@extends('layouts.admindashboard')
<!-- @section('title', 'Admin Profile') -->

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block">
                                <div class="card card-bordered">
                                    <div class="card-aside-wrap">
                                         @yield('profile')
                                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                            <div class="card-inner-group" data-simplebar>
                                                <div class="card-inner">
                                                    <div class="user-card">
                                                        <a href="{{ route('profile-pic') }}">
                                                        @if(file_exists(auth()->guard('admin')->user()->image))
                                                            <div class="user-avatar bg-blue">
                                                                <img src="{{url(auth()->guard('admin')->user()->image)}}" alt="">
                                                            </div>
                                                        @else
                                                            <div class="user-avatar bg-blue">
                                                                <img src="{{url('assets/images/profile.png')}}" alt="">
                                                            </div>
                                                        @endif
                                                        </a>
                                                        <div class="user-info">
                                                            <span class="lead-text">{{ auth()->guard('admin')->user()->name }}</span>
                                                            <span class="sub-text">{{ auth()->guard('admin')->user()->email }}</span>
                                                        </div>
                                                        <div class="user-action">
                                                            <div class="dropdown">
                                                                <a class="btn btn-icon btn-trigger mr-n2" data-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="{{ route('profile-pic') }}"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a></li>
                                                                        <li><a href="{{ route('profile') }}"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .user-card -->
                                                </div><!-- .card-inner -->
                                                <div class="card-inner">
                                                    <div class="user-account-info py-0">
                                                        <h6 class="overline-title-alt">Admin Username</h6>
                                                        <div class="user-balance">{{ auth()->guard('admin')->user()->username }}</div>
                                                        <div class="user-balance-sub">Current IP: <span>{{request()->ip()}}</span></div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner p-0">
                                                    <ul class="link-list-menu">
                                                        <li><a class="@if(Request::url() == route('profile')) active @endif" href="{{ route('profile') }}"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                                                        <li><a class="@if(Request::url() == route('account-activity')) active @endif" href="{{ route('account-activity') }}"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
                                                        <li><a class="@if(Request::url() == route('security-settings')) active @endif" href="{{ route('security-settings') }}"><em class="icon ni ni-lock-alt-fill"></em><span>Security Settings</span></a></li>
                                                        <li><a class="@if(Request::url() == route('change-password')) active @endif" href="{{ route('change-password') }}"><em class="icon ni ni-shield-star-fill"></em><span>Password Change</span></a></li>
                                                        <li><a class="" href="{{ route('adminLogout') }}"><em class="icon ni ni-signout"></em><span>Sign Out</span></a></li>
                                                    </ul>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card-inner-group -->
                                        </div><!-- card-aside -->
                                    </div><!-- .card-aside-wrap -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

    <!-- @@ Profile Edit Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Update Profile</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal">Personal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#address">Address</a>
                        </li>
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <form method="POST" action="{{route('profile.personal')}}" class="form-validate is-alter">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name">Fullname</label>
                                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{auth()->guard('admin')->user()->name}}" placeholder="Enter Fullname">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="display-name">Username</label>
                                            <input type="text" class="form-control form-control-lg" id="username" name="username" value="{{auth()->guard('admin')->user()->username}}" placeholder="Enter username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="phone-no">Phone Number</label>
                                            <input type="number" class="form-control form-control-lg" id="phone-no" name="phone" value="{{auth()->guard('admin')->user()->phone}}" placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <button class="btn btn-lg btn-primary" type="submit">Update Profile</button>
                                            </li>
                                            <li>
                                                <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div><!-- .tab-pane -->
                        <div class="tab-pane" id="address">
                            <form method="POST" action="{{route('profile.address')}}" class="form-validate is-alter">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="address-l1">Address</label>
                                            <input type="text" class="form-control form-control-lg" id="address-l1" name="address" value="{{auth()->guard('admin')->user()->address}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="address-st">City</label>
                                            <input type="text" class="form-control form-control-lg" id="address-st" name="city" value="{{auth()->guard('admin')->user()->city}}" >
                                        </div>
                                    </div>
                                    @php
                                        $states = \App\Models\State::whereStatus(1)->orderBy('id','asc')->get();
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="address-county">State</label>
                                            <select class="form-select" id="address-county" data-ui="lg" name="state">
                                                <option value="{{auth()->guard('admin')->user()->state}}">{{auth()->guard('admin')->user()->state}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->name}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <button class="btn btn-lg btn-primary" type="submit">Update Address</button>
                                            </li>
                                            <li>
                                                <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div><!-- .tab-pane -->
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->

    <!-- @@ Change Password Modal @e -->
    <!-- Modal Zoom -->
    <div class="modal fade zoom" tabindex="-1" id="change-password">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('submit-new-password')}}" class="form-validate is-alter">
                        @csrf
                        <input type="hidden" class="form-control form-control-lg" id="id" name="id" value="{{auth()->guard('admin')->user()->id}}">
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Current Password</label>
                                    <input type="password" class="form-control form-control-lg" id="full-name" name="current_password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="display-name">New Password</label>
                                    <input type="password" class="form-control form-control-lg" id="display-name" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="phone-no">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-lg" id="phone-no" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li>
                                        <button class="btn btn-lg btn-primary" type="submit">Change Password</button>
                                    </li>
                                    <li>
                                        <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection