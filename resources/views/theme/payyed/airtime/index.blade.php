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
                            <form id="form-send-money" method="POST" action="{{ route('validate-airtime') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="number">Mobile Number</label>
                                    <input type="number" name="number" class="form-control" data-bv-field="amount" id="number" autocomplete="offInput" minlength="11" maxlength="11" required placeholder="Mobile Number 080...">
                                </div>
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
                                    <label for="paymentMethod">Airtime Provider</label>
                                    <span class="input-group-text p-0">
                                        <select id="provider" onchange="calculate();" data-style="custom-select bg-transparent border-0" data-container="body" data-live-search="true" name="provider" class="selectpicker form-control bg-transparent" required>
                                            <optgroup label="Popular Currency">
                                                @foreach ($lists as $data)
                                                    <option data-icon="isp-provider isp-provider-{{Str::lower($data->provider)}} mr-1" data-subtext="{{$data->provider}}" value="{{$data->provider}}" data-cent="{{$data->c_cent}}" data-minAmount="{{$data->minAmount}}">{{$data->provider}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </span>
                                </div>
                                {{-- <div class="select-box" style="margin: 0 0 300px 0;">
                                    <div class="xpay-select">
                                        <input type="text" id="select-value" value="value 1">
                                        <div class="select__header">
                                            <div class="select__current"><img src="https://i.ibb.co/PtvKXTq/sber.png" alt=""> Value 1</div>
                                            <div class="select__icon">&#x002C7;</div>
                                        </div>

                                        <div class="select__body">
                                            <div class="select__item" data-image='https://i.ibb.co/PtvKXTq/sber.png' data-value="value 1"><img
                                                    src="https://i.ibb.co/PtvKXTq/sber.png" alt=""> Value 1</div>
                                            <div class="select__item" data-image='https://i.ibb.co/mB2j6Yz/perfect.png' data-value="value 2"><img
                                                    src="https://i.ibb.co/mB2j6Yz/perfect.png" alt=""> Value 2</div>
                                        </div>
                                    </div>
                                </div> --}}
                                <p class="text-muted mt-4">
                                    Transaction discount <span class="float-right d-flex align-items-center"><span id="discount">{{$basic->currency_sym.number_format(0,$basic->decimal)}}</span></span>
                                </p>
                                <p class="text-muted mt-4">
                                    Transaction fee <span class="float-right d-flex align-items-center"><span class="bg-info text-1 text-white font-weight-500 rounded d-inline-block px-2 line-height-4 ml-2">Free</span></span>
                                </p>
                                <hr />
                                <p class="text-4 font-weight-500">You'll pay <span class="float-right" id="total">{{$basic->currency_sym.number_format(0,$basic->decimal)}}</span></p>
                                <button id="show" class="btn btn-primary btn-block" onclick="this.form.requestSubmit(); mySubmitFunction();">Continue</button>
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
                var cent = $("#provider option:selected").attr('data-cent');
                var minAmount = $("#provider option:selected").attr('data-minAmount');

                if (cent > 0) {
                    var discount = amount * (cent/100);
                }else{
                    var discount = 0;
                }

                var total = amount - discount;

                document.getElementById("discount").innerHTML = '{{$basic->currency_sym}}'+discount.toLocaleString("en-US");
                document.getElementById("total").innerHTML = '{{$basic->currency_sym}}'+total.toLocaleString("en-US");
            };

            function mySubmitFunction() {
                var amount = $('#amount').val();
                var number = $('#number').val();
                var cent = $("#provider option:selected").attr('data-cent');
                var minAmount = $("#provider option:selected").attr('data-minAmount');
                if (amount != "" && amount > minAmount && number.length > 9) {
                    document.getElementById("show").innerHTML = "<div class='spinner'><div class='double-bounce1'></div><div class='double-bounce2'></div></div>";
                    document.getElementById("show").disabled = true;
                }
            };
        </script>

        <script>
            document.querySelectorAll('.xpay-select').forEach(select => {

                let selectArr = select.querySelectorAll('.xpay-select'),
                    selectHeader = select.querySelectorAll('.select__header'),
                    selectItem = select.querySelectorAll('.select__item'),
                    currentItem = select.querySelector('.select__current'),
                    selectInput = select.querySelector('#select-value');

                selectHeader.forEach(item => {
                    item.addEventListener('click', selectToggle);
                });

                selectItem.forEach(item => {
                    item.addEventListener('click', selectChoose);
                });

                function selectToggle() {
                    this.parentElement.classList.toggle('is-active');
                }

                function selectChoose() {
                    let selectOption = this.innerText,
                        imgs = this.getAttribute("data-image"),
                        thisSelect = this.closest('.xpay-select');
                    currentItem.innerHTML = `<img src="` + imgs + `"/> ` + selectOption;
                    selectInput.value = selectOption;
                    thisSelect.classList.remove('is-active');
                    console.log(selectInput.value);
                }

                document.addEventListener('click', (e) => {
                    if (!select.contains(e.target)) {
                        select.classList.remove('is-active');
                    }
                });

            });
        </script>

@endsection
