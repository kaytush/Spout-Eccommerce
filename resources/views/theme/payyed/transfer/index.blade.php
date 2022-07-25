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
                            @error('bankName')
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                            @error('bank_code')
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                            @error('acc_name')
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                            @error('username')
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                            <!-- Deposit Money Form
                    ============================================= -->
                            <div class="text-center bg-primary p-4 rounded mb-4">
                                <h3 class="text-10 text-white font-weight-400">{{$gnl->currency_sym.number_format(auth()->user()->balance, $gnl->decimal)}}</h3>
                                <p class="text-white">Available Balance</p>
                                <a href="javascript:void(0);" onclick="fullAmount();" class="btn btn-outline-light btn-sm shadow-none text-uppercase rounded-pill text-1">Transfer Full Amount</a>
                            </div>
                            <form id="form-send-money" method="POST" action="{{ route('validate-transfer') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="youSend">Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">{{$basic->currency_sym}}</span></div>
                                        <input type="number" class="form-control" data-bv-field="youSend" id="amount" name="amount" onkeyup="calculate();" required placeholder="0" />
                                        <div class="input-group-append">
                                            <span class="input-group-text p-0">
                                                <select id="youSendCurrency" data-style="custom-select bg-transparent border-0" data-container="body" data-live-search="true" class="selectpicker form-control bg-transparent">
                                                    <optgroup label="Popular Currency">
                                                        <option data-icon="currency-flag currency-flag-ngn mr-1" data-subtext="Nigerian Naira" selected="selected" value="">{{$basic->currency}}</option>
                                                    </optgroup>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="withdrawto">Destination Bank</label>
                                    <select id="provider" onchange="switchP();" class="custom-select" name="bank_code" required="">
                                    <option value="0">{{$gnl->sitename}} (Internal Transfer)</option>
                                    @foreach ($list as $data)
                                        <option value="{{$data['bank_code']}}" data-bank="{{$data['bank_name']}}">{{$data['bank_name']}}</option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" id="bankName" name="bankName" value="{{$gnl->sitename}}" />
                                </div>
                                <div class="form-group" id="switch1">
                                    <label for="number">Account Email/Username/Phone Number</label>
                                    <input type="text" name="username" class="form-control" data-bv-field="amount" id="username" data-type="0" autocomplete="offInput" onkeyup="verify(this.value)" placeholder="Email/Username/Phone Number">
                                </div>
                                <div class="form-group" id="switch2" style="display: none">
                                    <label for="number">Account Number</label>
                                    <input type="number" name="number" class="form-control" data-bv-field="amount" id="number" data-type="1" autocomplete="offInput" onkeyup="vverify(this.value)" placeholder="Account Number">
                                </div>
                                <p class="text-muted text-center"><span class="font-weight-500" id="accname"></span></p>
                                <hr>
                                <p class="text-muted mt-4">
                                    Transaction fee <span class="float-right d-flex align-items-center" id="fee"><span class="bg-info text-1 text-white font-weight-500 rounded d-inline-block px-2 line-height-4 ml-2">Free</span></span>
                                </p>
                                <hr />
                                <input type="hidden" id="acc_name" name="acc_name" />
                                <p class="text-4 font-weight-500">You'll pay <span class="float-right" id="total">{{$basic->currency_sym.number_format(0,$basic->decimal)}}</span></p>
                                <button id="show" class="btn btn-primary btn-block" disabled onclick="this.form.requestSubmit(); mySubmitFunction();">Continue</button>
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
                var amount = $('#amount').val();
                var bank = $("#provider option:selected").val();
                var fee = "{{$basic->transfer_fee}}";
                var minAmount = 100;

                var total = parseInt(amount) + parseInt(fee);

                if(fee == 0){
                    document.getElementById("fee").innerHTML = '<span class="bg-info text-1 text-white font-weight-500 rounded d-inline-block px-2 line-height-4 ml-2">Free</span>';
                }else{
                    document.getElementById("fee").innerHTML = '{{$basic->currency_sym}}'+fee.toLocaleString("en-US");
                }

                document.getElementById("total").innerHTML = '{{$basic->currency_sym}}'+total.toLocaleString("en-US");
            };

            function fullAmount() {
                var amount = parseInt("{{auth()->user()->balance}}");
                var fee = parseInt("{{$basic->transfer_fee}}");
                var number = $('#number').val();
                var minAmount = 100;
                var total = parseInt(amount) - parseInt(fee);

                if(total >  0){
                    $("#amount").val(total);
                }else{
                    $("#amount").val(0);
                }

                if(fee == 0){
                    document.getElementById("fee").innerHTML = '<span class="bg-info text-1 text-white font-weight-500 rounded d-inline-block px-2 line-height-4 ml-2">Free</span>';
                }else{
                    document.getElementById("fee").innerHTML = '{{$basic->currency_sym}}'+fee.toLocaleString("en-US");
                }

                document.getElementById("total").innerHTML = '{{$basic->currency_sym}}'+amount.toLocaleString("en-US");

                if (amount > minAmount && number.length > 3) {
                    document.getElementById("show").disabled = false;
                }else{
                    document.getElementById("show").disabled = true;
                }
            }

            function switchP() {
                var amount = $('#amount').val();
                var bank = $("#provider option:selected").val();
                var bankName = $("#provider option:selected").attr('data-bank');

                if (bank == 0) {
                    $("#bankName").val(bankName);
                    document.getElementById("switch1").style.display = 'block';
                    document.getElementById("switch1").reqired = true;
                    document.getElementById("switch2").style.display = 'none';
                }else if (bank > 0) {
                    $("#bankName").val(bankName);
                    document.getElementById("switch1").style.display = 'none';
                    document.getElementById("switch2").style.display = 'block';
                    document.getElementById("switch2").reqired = true;
                }


                // document.getElementById("total").innerHTML = '{{$basic->currency_sym}}'+total.toLocaleString("en-US");
            };

            function mySubmitFunction() {
                var amount = $('#amount').val();
                var number = $('#number').val();
                var username = $('#username').val();
                var provider = $("#provider option:selected").val();
                var minAmount = 100;

                if (amount != "" && amount > minAmount && number != "") {
                    document.getElementById("show").innerHTML = "<div class='spinner'><div class='double-bounce1'></div><div class='double-bounce2'></div></div>";
                    document.getElementById("show").disabled = true;
                }else if (amount != "" && amount > minAmount && username != "") {
                    document.getElementById("show").innerHTML = "<div class='spinner'><div class='double-bounce1'></div><div class='double-bounce2'></div></div>";
                    document.getElementById("show").disabled = true;
                }
            };

            function verify(username) {
                var provider = $("#provider option:selected").val();
                var type = $('#username').attr('data-type');
                var amount = $('#amount').val();
                var minAmount = 100;

                if (type == 0 && username.length > 4){
                    document.getElementById("accname").innerHTML = "Verifying....";
                    document.getElementById("show").disabled = true;
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var jRes=JSON.parse(this.responseText);
                            console.log(jRes);
                            if(jRes.success){
                                $("#acc_name").val(jRes.data.account_name);
                                document.getElementById("accname").innerHTML = jRes.data.account_name;
                                document.getElementById("show").innerHTML = "Continue";
                                document.getElementById("show").disabled = false;
                            }else{
                                $("#acc_name").val("-");
                                document.getElementById("accname").innerHTML = "-";
                                document.getElementById("show").innerHTML = "Continue";
                                document.getElementById("show").disabled = true;
                            }
                        }
                    };
                    xmlhttp.open("GET", "/account_name/validate/"+provider+"/"+username, true);
                    xmlhttp.send();
                }
            }

            function vverify(number) {
                var provider = $("#provider option:selected").val();
                var type = $('#number').attr('data-type');
                var amount = $('#amount').val();
                var minAmount = 100;

                if (type == 1 && number.length > 9) {
                    document.getElementById("accname").innerHTML = "Verifying....";
                    document.getElementById("show").disabled = true;
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var jRes=JSON.parse(this.responseText);
                            console.log(jRes);
                            if(jRes.success){
                                $("#acc_name").val(jRes.data.account_name);
                                document.getElementById("accname").innerHTML = jRes.data.account_name;
                                document.getElementById("show").innerHTML = "Continue";
                                document.getElementById("show").disabled = false;
                            }else{
                                $("#acc_name").val("-");
                                document.getElementById("accname").innerHTML = "-";
                                document.getElementById("show").innerHTML = "Continue";
                                document.getElementById("show").disabled = true;
                            }
                        }
                    };
                    xmlhttp.open("GET", "/account_name/validate/"+provider+"/"+number, true);
                    xmlhttp.send();
                }
            }
        </script>

@endsection
