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
                            <form id="form-send-money" action="{{route('transfer-now')}}" method="POST">
                                <div class="form-group">
                                    @csrf
                                    <input type="hidden" name="amount" value="{{$amount}}">
                                    <input type="hidden" name="number" value="{{$number}}">
                                    <input type="hidden" name="bankName" value="{{$bankName}}">
                                    <input type="hidden" name="bank_code" value="{{$bank_code}}">
                                </div>
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <p class="text-center">You are Transfering<br>
                                    to<br>
                                    <span class="font-weight-500">{{$bankName}} - {{$number}}<br>{{$acc_name}}</span></p>
                                </div>
                                <hr class="mx-n3 mx-sm-n5 mb-4" />
                                <p class="mb-1">Amount <span class="text-3 float-right">{{$basic->currency_sym.number_format($amount,$basic->decimal)}}</span></p>
                                <p class="mb-1">Fee <span class="text-3 float-right">{{$basic->currency_sym.number_format($fee,$basic->decimal)}}</span></p>
                                <hr />
                                <p class="text-4 font-weight-500">Total<span class="float-right">{{$basic->currency_sym.number_format(($amount + $fee),$basic->decimal)}}</span></p>
                                <button class="btn btn-primary btn-block" onclick="this.disabled=true;this.innerHTML='Processing...';this.form.submit();">Confirm</button>
                            </form>
                            <!-- Deposit Money Confirm end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content end -->

@endsection
