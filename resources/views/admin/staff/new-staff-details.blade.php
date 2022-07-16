@extends('layouts.admindashboard')
@section('title', 'New Account Details')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-lg nk-content-fluid">
                <div class="container-xl wide-lg">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="kyc-app wide-sm m-auto">
                                <div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
                                    <div class="nk-block-head-content text-center">
                                        <h2 class="nk-block-title fw-normal">New Staff Account Credentials</h2>
                                        <div class="nk-block-des">
                                            <p><font color="red">Kindly copy the Credentials below for the staff. You cannot refresh nor revisit this page.</font></p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-bordered">
                                        <div class="card-inner card-inner-lg">
                                            <div class="nk-kyc-app p-sm-2 text-center">
                                                <div class="nk-kyc-app-icon">
                                                    <em class="icon ni ni-shield-half"></em>
                                                </div>
                                                <div class="nk-kyc-app-text mx-auto">
                                                    <p class="lead"><b>Fullname:</b> {{$name}}</p>
                                                    <p class="lead"><b>Username:</b> {{$username}}</p>
                                                    <p class="lead"><b>Email:</b> {{$email}}</p>
                                                    <p class="lead"><b>Phone Number:</b> {{$phone}}</p>
                                                    <p class="lead"><b>Password:</b> <i>password</i> <code class="code-tag">(this is a default password)</code></p>
                                                    <p class="lead"><b>Role:</b> {{$role}}</p>
                                                </div>
                                                <div class="nk-kyc-app-action">
                                                    <a href="{{ route('staffs') }}" class="btn btn-lg btn-primary"><em class="icon ni ni-curve-up-left"></em><span>Return to Staff List</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div> <!-- .nk-block -->
                            </div><!-- .kyc-app -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
@endsection