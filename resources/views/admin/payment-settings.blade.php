@extends('layouts.admindashboard')
@section('title', 'Payment Settings')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="components-preview">
                                <div class="nk-block-head nk-block-head-lg text-center">
                                    <div class="nk-block-head-content">
                                        <h2 class="nk-block-title fw-normal">Payment Settings</h2>
                                    </div>
                                </div><!-- .nk-block -->
                                <div class="nk-block nk-block-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content text-center">
                                            <h4 class="title nk-block-title">Update Payment Credentials</h4>
                                            <div class="nk-block-des">
                                                <p>This is a sensitive section. Kindly fill in correct details carefully.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-gs">
                                        <div class="col-lg-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <h5 class="card-title">Flutterwave API</h5>
                                                    </div>
                                                    <form action="{{ route('update.online.gateway') }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label class="form-label" for="display-name">Display Name</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="display-name" value="{{$gateway->main_name}}" name="main_name" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="gateway-name">Gateway Name</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="gateway-name" value="{{$gateway->name}}" name="name" readonly required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="public-key">Flutterwave Public Key</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="public-key" value="{{$gateway->val1}}" name="val1" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="secret-key">Flutterwave Secret Key</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="secret-key" value="{{$gateway->val2}}" name="val2">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-lg btn-primary">Update Details</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <h5 class="card-title">Offline Payment</h5>
                                                    </div>
                                                    <form action="{{ route('update.offline.gateway') }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label class="form-label" for="display-nam">Display name</label>
                                                            <input type="text" class="form-control" id="display-name" value="{{$offline->main_name}}" name="main_name" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="bank-name">Bank Name</label>
                                                            <input type="text" class="form-control" id="bank-name" value="{{$offline->name}}" name="name" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="account-name">Account Name</label>
                                                            <input type="text" class="form-control" id="account-name" value="{{$offline->val1}}" name="val1" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="account-number">Account Number</label>
                                                            <input type="text" class="form-control" id="account-number" value="{{$offline->val2}}" name="val2" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-lg btn-primary">Update Details</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
                            </div><!-- .components-preview -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
@endsection
