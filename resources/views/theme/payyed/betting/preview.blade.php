@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

        <!-- Content
        ============================================= -->
        <div id="content" class="py-4">
            <div class="container">
                <!-- Steps Progress bar -->
                <div class="row mt-4 mb-5">
                    <div class="col-lg-11 mx-auto">
                        <div class="row widget-steps">
                            <div class="col-4 step complete">
                                <div class="step-name">Details</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0);" class="step-dot"></a>
                            </div>
                            <div class="col-4 step active">
                                <div class="step-name">Confirm</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0);" class="step-dot"></a>
                            </div>
                            <div class="col-4 step disabled">
                                <div class="step-name">Success</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0);" class="step-dot"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="font-weight-400 text-center mt-3 mb-4">{{$page_title}}</h2>
                <div class="row">
                    <div class="col-md-9 col-lg-7 col-xl-6 mx-auto">
                        <div class="bg-white shadow-sm rounded p-3 pt-sm-4 pb-sm-5 px-sm-5 mb-4">
                            <div class="text-center">
                                <img style="border-radius: 20px" src="{{url($bet->providerLogoUrl)}}" width="80px" height="80px" alt="avatar">
                            </div>
                            <hr class="mx-n3 mx-sm-n5 mb-4" />
                            <!-- Deposit Money Confirm
                    ============================================= -->
                            @if (session('error'))
                                <div class="alert alert-danger rounded shadow-sm">
                                    <div class="form-row align-items-center">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                            @if (session('alert'))
                                <div class="alert alert-warning rounded shadow-sm">
                                    <div class="form-row align-items-center">
                                        {{ session('alert') }}
                                    </div>
                                </div>
                            @endif
                            <form id="form-send-money" action="{{route('buy-betting')}}" method="POST">
                                <div class="form-group">
                                    @csrf
                                    <input type="hidden" name="provider" value="{{$provider}}">
                                    <input type="hidden" name="number" value="{{$number}}">
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                </div>
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        <p class="col-sm-5 opacity-7 text-sm-right mb-0 mb-sm-3">Provider:</p>
                                        <p class="col-sm-7 text-3">{{$provider}}</p>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <p class="col-sm-5 opacity-7 text-sm-right mb-0 mb-sm-3">UserID/CustomerID:</p>
                                        <p class="col-sm-7 text-3">{{$number}}</p>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <p class="col-sm-5 opacity-7 text-sm-right mb-0 mb-sm-3">Firstname:</p>
                                        <p class="col-sm-7 text-3">{{$firstName}}</p>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <p class="col-sm-5 opacity-7 text-sm-right mb-0 mb-sm-3">Lastname:</p>
                                        <p class="col-sm-7 text-3">{{$lastName}}</p>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <p class="col-sm-5 opacity-7 text-sm-right mb-0 mb-sm-3">Username:</p>
                                        <p class="col-sm-7 text-3">{{$userName}}</p>
                                    </div>
                                    {{-- <div class="form-row align-items-center">
                                        <p class="col-sm-5 opacity-7 text-sm-right mb-0">Wallet Balance:</p>
                                        <p class="col-sm-7 text-3 mb-0"><font @if(auth()->user()->balance > $amount) color="green" @else color="red" @endif>{{ $basic->currency_sym.number_format(auth()->user()->balance, $basic->decimal) }}</font></p>
                                    </div> --}}
                                </div>
                                <hr class="mx-n3 mx-sm-n5 mb-4" />
                                <h3 class="text-5 font-weight-400 mb-4">Details</h3>
                                <hr class="mx-n3 mx-sm-n5 mb-4" />
                                <p class="mb-1">Wallet Balance <span class="text-3 float-right"><font @if(auth()->user()->balance > $amount) color="green" @else color="red" @endif>{{ $basic->currency_sym.number_format(auth()->user()->balance, $basic->decimal) }}</font></span></p>
                                {{-- <p class="mb-1">Data Plan <span class="text-3 float-right">{{$plan->name}}</span></p> --}}
                                <p class="mb-1">Data Amount <span class="text-3 float-right">{{$basic->currency_sym.number_format($amount,$basic->decimal)}}</span></p>
                                <p class="mb-1">Discount <span class="text-3 float-right">{{$basic->currency_sym.number_format($discount,$basic->decimal)}}</span></p>
                                <p class="mb-1">Fee <span class="text-3 float-right">{{$basic->currency_sym.number_format(0,$basic->decimal)}}</span></p>
                                <hr />
                                <p class="text-4 font-weight-500">Total<span class="float-right">{{$basic->currency_sym.number_format(($amount - $discount),$basic->decimal)}}</span></p>
                                <button class="btn btn-primary btn-block" onclick="this.disabled=true;this.innerHTML='Processing...';this.form.requestSubmit();">Confirm</button>
                            </form>
                            <!-- Deposit Money Confirm end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content end -->

@endsection
