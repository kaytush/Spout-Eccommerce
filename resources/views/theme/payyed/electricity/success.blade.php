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
                                <span class="step-dot"></span>
                            </div>
                            <div class="col-4 step complete">
                                <div class="step-name">Confirm</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <span class="step-dot"></span>
                            </div>
                            <div class="col-4 step complete">
                                <div class="step-name">Success</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <span class="step-dot"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="font-weight-400 text-center mt-3 mb-4">{{$page_title}}</h2>
                <div class="row">
                    <div class="col-md-9 col-lg-7 col-xl-6 mx-auto">
                        <!-- Request Money Success
                ============================================= -->
                        <div class="bg-white text-center shadow-sm rounded p-3 pt-sm-4 pb-sm-5 px-sm-5 mb-4">
                            <div class="my-4">
                                <p class="text-success text-20 line-height-07"><i class="fas fa-check-circle"></i></p>
                                <p class="text-success text-8 font-weight-500 line-height-07">Success!</p>
                                <p class="lead">{{session('success')}}</p>
                            </div>
                            <p class="text-3 mb-4">You've successfully purchased <span class="text-4 font-weight-500">{{$basic->currency_sym.number_format(session('amount'),$basic->decimal)}}</span> worth of Electricity Bill on <span class="text-4 font-weight-500">{{session('number')}}</span>, See transaction details in <a class="btn-link" href="{{route('transactions')}}">Transaction History</a>.</p>
                            <a href="{{route('electricity')}}" data-turbo="false" class="btn btn-primary btn-block">Recharge Electricity Again</a>
                            <a class="text-3 d-inline-block btn-link mt-4" href="javascript:void(0);" onclick="window.print();"><i class="fas fa-print"></i> Print</a>
                        </div>
                        <!-- Request Money Success end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Content end -->

@endsection
