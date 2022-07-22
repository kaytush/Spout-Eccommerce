@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')
        <style>
            .xpay-select {
                position: relative;
                width: 250px;
                margin: 0 auto;
            }

            .xpay-select.is-active .select__body {
                display: block;
            }

            .select__header {
                display: flex;
                padding: 5px;
                border: 1px solid #000;
                cursor: pointer;
            }

            .select__icon {
                margin: 0 0 0 auto;
            }

            .select__current {
                display: flex;
                align-items: center;
            }

            .select__current img {
                width: 20px;
            }

            .select__body {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                display: none;
                border: 1px solid;
                border-top: none;
            }

            .select__item {
                display: flex;
                align-items: center;
                padding: 5px;
                cursor: pointer;
            }

            .select__item img {
                width: 20px;
            }

            .select__item:hover {
                background: #F2F2F2;
            }
        </style>

        <!-- Content
        ============================================= -->
        <div id="content" class="py-4">
            <div class="container">
                <!-- Steps Progress bar -->
                <div class="row mt-4 mb-5">
                    <div class="col-lg-11 mx-auto">
                        <div class="row widget-steps">
                            <div class="col-4 step active">
                                <div class="step-name">Details</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0);" class="step-dot"></a>
                            </div>
                            <div class="col-4 step disabled">
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
                        <div class="bg-white shadow-sm rounded p-3 pt-sm-5 pb-sm-5 px-sm-5 mb-4">
                            @if (session('error'))
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                            @error('number')
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                            @error('amount')
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                            <!-- Deposit Money Form
                    ============================================= -->
                            <form id="addbankaccount" method="POST" action="{{ route('card-funding') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="bankName">Payment Method</label>
                                    <select class="custom-select" onchange="calculate();" id="bankName" name="bankName">
                                        <option value=""> Please Select </option>
                                        @if (env('BUD_SWITCH') == 1)
                                            <option value="budpay">Budpay</option>
                                        @endif
                                        @if (env('FLUTTERWAVE_SWITCH') == 1)
                                            <option value="flutterwave">Flutterwave</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="accountNumber">Amount</label>
                                    <input type="number" class="form-control" data-bv-field="accountNumber" onkeyup="calculate();" id="accountNumber" min="100" name="amount" required value="" placeholder="100" />
                                </div>
                                <p id="show"><button class="btn btn-primary btn-block" disabled> ... </button></p>
                            </form>
                            <!-- Deposit Money Form end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content end -->

        <script>
                function calculate() {
                    var amount = $('#accountNumber').val();
                    var gate = $("#bankName option:selected").val();

                    if (amount != "" && amount.length > 2 && gate != "") {
                        document.getElementById("show").innerHTML = "<button class='btn btn-primary btn-block' onclick='this.form.requestSubmit(); mySubmitFunction();'>Fund Now</button>";
                    }else{
                        document.getElementById("show").innerHTML = "<button class='btn btn-primary btn-block' disabled> ... </button>";
                    }
                };

                function mySubmitFunction() {
                    document.getElementById("show").innerHTML = "<button class='btn btn-primary btn-block' disabled><div class='spinner'><div class='double-bounce1'></div><div class='double-bounce2'></div></div></button>";
                };
        </script>

@endsection
