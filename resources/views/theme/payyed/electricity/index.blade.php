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
                            @error('code')
                                <div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-5">
                                    <div class="form-row align-items-center">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                            <!-- Deposit Money Form
                    ============================================= -->
                            <form id="form-send-money" method="POST" action="{{ route('validate-internet') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="number">Mobile Number</label>
                                    <input type="number" name="number" class="form-control" data-bv-field="amount" id="number" autocomplete="offInput" minlength="11" maxlength="11" required placeholder="Mobile Number 080...">
                                </div>
                                <div class="form-group">
                                    <label for="paymentMethod">Internet Provider</label>
                                    <span class="input-group-text p-0">
                                        <select id="provider" onchange="chooseType(this.value)" data-style="custom-select bg-transparent border-0" data-container="body" data-live-search="true" name="provider" class="selectpicker form-control bg-transparent" required>
                                            <optgroup label="Popular Currency">
                                                @foreach ($lists as $data)
                                                    <option data-icon="isp-provider isp-provider-{{Str::lower($data->provider)}} mr-1" data-subtext="{{$data->provider}}" value="{{$data->provider}}">{{$data->provider}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="inputCountry">Data Plan</label>
                                    <select class="custom-select" id="code" name="code" onchange="calculate();">
                                        <option value="">Select Data Plan</option>
                                        @foreach ($airtel as $data)
                                            <option value="{{$data->id}}">{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                var code = $("#code option:selected").val();
                console.log(code);
                var c_cent = "{{App\Models\InternetData::where('id',232)->first()->c_cent}}";
                console.log("c cent: "+c_cent);
                var api_cent = "{{App\Models\InternetData::where('id',232)->first()->api_cent}}";
                var amount = "{{App\Models\InternetData::where('id',232)->first()->amount}}";
                console.log("api cent: "+api_cent);
                var level="{{auth()->user()->level}}";
                console.log("Level: "+level);
                var curr = '{{$basic->currency_sym}}';
                console.log("Currency: "+curr);
                console.log("stage 1");

                if (level == 0) {
                    if (c_cent > 0) {
                        var discount = amount * (c_cent/100);
                    }else{
                        var discount = 0;
                    }

                }else if (level > 0) {
                    if (api_cent > 0) {
                        var discount = amount * (api_cent/100);
                    }else{
                        var discount = 0;
                    }
                }
                console.log("stage 2");

                var total = 1000 - discount;

                document.getElementById("discount").innerHTML = '{{$basic->currency_sym}}'+discount.toLocaleString("en-US");
                document.getElementById("total").innerHTML = '{{$basic->currency_sym}}'+total.toLocaleString("en-US");
            };

            function mySubmitFunction() {
                var code = $('#code option:selected').val();
                var number = $('#number').val();
                if (code != "" && number.length > 9) {
                    document.getElementById("show").innerHTML = "<div class='spinner'><div class='double-bounce1'></div><div class='double-bounce2'></div></div>";
                    document.getElementById("show").disabled = true;
                }
            };

            function chooseType(id) {
                selectBox=document.getElementById('code');
                removeAll(selectBox);

                var cars=<?php echo $plans; ?>;
                for (let i = 0; i < cars.length; i++) {
                    if(cars[i].ip_name == id) {
                        let newOption = new Option(cars[i].name +' (<?php echo $gnl->currency_sym; ?>' + cars[i].amount +')', cars[i].id);
                        selectBox.add(newOption, undefined);
                    }
                }
            }

            function removeAll(selectBox) {
                while (selectBox.options.length > 0) {
                    selectBox.remove(0);
                }
            }
        </script>

@endsection
