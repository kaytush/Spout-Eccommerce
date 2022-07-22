@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

  <div id="content" class="py-4">
    <div class="container">
      <div class="row">
        @include('theme.'.$basic->theme.'.layouts.leftpanel')
        <!-- Middle Panel
        ============================================= -->
        <div class="col-lg-9">

          <!-- Bank Accounts
          ============================================= -->
          <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-4">Bank Accounts <span class="text-muted text-4">({{$basic->currency_sym.number_format($basic->vacc_fee, $basic->decimal)}} Deposit Fee)</span></h3>
            <hr class="mb-4 mx-n4">
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="account-card account-card-primary text-white rounded mb-4 mb-lg-0">
                  <div class="row no-gutters">
                    <div class="col-3 d-flex justify-content-center p-3">
                      <div class="my-auto text-center"> <span class="text-13"><i class="fas fa-university"></i></span>
                        <p class="badge badge-warning text-0 font-weight-500 rounded-pill px-2 mb-0">Primary</p>
                      </div>
                    </div>
                    <div class="col-9 border-left">
                      <div class="py-4 my-2 pl-4">
                        <p class="text-4 font-weight-500 mb-1">@if(auth()->user()->bank_name != NULL) {{auth()->user()->bank_name}} @else Bank Name @endif</p>
                        <p class="text-4 opacity-9 mb-1">@if(auth()->user()->account_number != NULL) XXXXXXXXXXXX-{{substr(auth()->user()->account_number, -4)}} @else XXXXXXXXXXXX @endif</p>
                        <p class="m-0">@if(auth()->user()->account_number != NULL) Approved <span class="text-3"><i class="fas fa-check-circle"></i></span> @else Pending @endif</p>
                      </div>
                    </div>
                  </div>
                  <div class="account-card-overlay rounded"> <a href="javascript:void(0);" @if(auth()->user()->account_number != NULL) data-target="#bank-account-details" data-toggle="modal" @endif class="text-light btn-link mx-2"><span class="mr-1"><i class="fas fa-share"></i></span>View Details</a></div>
                </div>
              </div>
              <div class="col-12 col-sm-6"> <a href="javascript:void(0);" data-target="#add-new-bank-account" data-toggle="modal" class="account-card-new d-flex align-items-center rounded h-100 p-3 mb-4 mb-lg-0">
                <p class="w-100 text-center line-height-4 m-0"> <span class="text-3"><i class="fas fa-plus-circle"></i></span> <span class="d-block text-body text-3">New Card Deposit</span> </p>
                </a> </div>
            </div>
          </div>
          <!-- View Bank Account Details Modal
          ======================================== -->
          <div id="bank-account-details" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered transaction-details" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="row no-gutters">
                    <div class="col-sm-5 d-flex justify-content-center bg-primary rounded-left py-4">
                      <div class="my-auto text-center">
                        <div class="text-17 text-white mb-3"><i class="fas fa-university"></i></div>
                        <h3 class="text-6 text-white my-3">{{auth()->user()->bank_name}}</h3>
                        <div class="text-4 text-white my-4">XXX-{{substr(auth()->user()->account_number, -4)}} | NGN</div>
                        <p class="badge badge-light text-0 font-weight-500 rounded-pill px-2 mb-0">Primary</p>
                      </div>
                    </div>
                    <div class="col-sm-7">
                      <h5 class="text-5 font-weight-400 m-3">Bank Account Details
                        <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                      </h5>
                      <hr>
                      <div class="px-3">
                        <ul class="list-unstyled">
                          <li class="font-weight-500">Account Type:</li>
                          <li class="text-muted">Personal</li>
                        </ul>
                        <ul class="list-unstyled">
                          <li class="font-weight-500">Account Name:</li>
                          <li class="text-muted">{{auth()->user()->account_name}}</li>
                        </ul>
                        <ul class="list-unstyled">
                          <li class="font-weight-500">Account Number:</li>
                          <li class="text-muted">{{auth()->user()->account_number}}</li>
                        </ul>
                        <ul class="list-unstyled">
                          <li class="font-weight-500">Bank Name:</li>
                          <li class="text-muted">{{auth()->user()->bank_name}}</li>
                        </ul>
                        <ul class="list-unstyled">
                          <li class="font-weight-500">Status:</li>
                          <li class="text-muted">Approved <span class="text-success text-3"><i class="fas fa-check-circle"></i></span></li>
                        </ul>
                        <p id="cp"><a href="javascript:void(0);" data-clipboard-text="{{auth()->user()->account_number}}" onclick="copyFunc()" class="btn btn-sm btn-outline-success btn-block shadow-none"><span class="mr-1"><i class="fas fa-clone"></i></span>Copy Account</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Add New Bank Account Details Modal
          ======================================== -->
            <div id="add-new-bank-account" class="modal fade" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-400">Card Deposit <span class="text-muted text-4">(1.4% Fee)</span></h5>
                            <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body p-4">
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
                                    <input type="number" class="form-control" data-bv-field="accountNumber" onkeyup="calculate();" id="accountNumber" name="amount" required value="" placeholder="100" />
                                </div>
                                <p id="show"><button class="btn btn-primary btn-block" disabled> ... </button></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bank Accounts End -->


          <!-- Data Balance Code
          =============================== -->
          <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 d-flex align-items-center mb-4">Data Balance Code</h3>
            <hr class="mb-4 mx-n4">
            <div class="row profile-completeness">
              <div class="col-sm-6 col-md-3 mb-4 mb-md-0">
                <div class="border rounded text-center px-3 py-4"> <span class="d-block text-10 text-light mt-2 mb-3">{!! config('techplus-trx-icon.mtn') !!}</span> <span class="text-1 d-block text-success mt-4 mb-3">*461*4# | *131*4#</span>
                  <p class="mb-0">MTN</p>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 mb-4 mb-md-0">
                <div class="border rounded text-center px-3 py-4"> <span class="d-block text-10 text-light mt-2 mb-3">{!! config('techplus-trx-icon.airtel') !!}</span> <span class="text-1 d-block text-success mt-4 mb-3">*140#</span>
                  <p class="mb-0">Airtel</p>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 mb-4 mb-sm-0">
                <div class="border rounded text-center px-3 py-4"> <span class="d-block text-10 text-light mt-2 mb-3">{!! config('techplus-trx-icon.glo') !!}</span> <span class="text-1 d-block text-success mt-4 mb-3">*127*0#</span>
                  <p class="mb-0">Glo</p>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="border rounded text-center px-3 py-4"> <span class="d-block text-10 text-light mt-2 mb-3">{!! config('techplus-trx-icon.9mobile') !!}</span> <span class="text-1 d-block text-success mt-4 mb-3">*228#</span>
                  <p class="mb-0">9mobile</p>
                </div>
              </div>
            </div>
          </div>
          <!-- Data Balance Code End -->

          <!-- Recent Activity
          =============================== -->
          <div class="bg-white shadow-sm rounded py-4 mb-4">
            <h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-4">Recent Trasactions</h3>

            <!-- Title
            =============================== -->
            <div class="transaction-title py-2 px-4">
              <div class="row font-weight-00">
                <div class="col-2 col-sm-1 text-center"><span class="">Date</span></div>
                <div class="col col-sm-7">Description</div>
                <div class="col-auto col-sm-2 d-none d-sm-block text-center">Status</div>
                <div class="col-3 col-sm-2 text-right">Amount</div>
              </div>
            </div>
            <!-- Title End -->

            <!-- Transaction List
            =============================== -->
            <div class="transaction-list">
                @if (count($trxs) > 0)
                    @foreach ($trxs as $data)
                        <div class="transaction-item px-4 py-3" data-toggle="modal" data-target="#transaction-detail-{{$data->id}}">
                            <div class="row align-items-center flex-row">
                            <div class="col-2 col-sm-1 text-center"> <span class="d-block text-4 font-weight-300">{!! date('d', strtotime($data->created_at)) !!}</span> <span class="d-block text-1 font-weight-300 text-uppercase">{!! date('M', strtotime($data->created_at)) !!}</span> </div>
                            <div class="col col-sm-7"> <span class="d-block text-4">{{$data->title}}</span> <span class="text-muted">{{$data->description}}</span> </div>
                            <div class="col-auto col-sm-2 d-none d-sm-block text-center text-3">
                                @if ($data->status == "successful" || $data->status == "SUCCESSFUL")
                                    <span class="text-success" data-toggle="tooltip" data-original-title="Successful"><i class="fas fa-check-circle"></i></span>
                                @elseif ($data->status == "delivered")
                                    <span class="text-success" data-toggle="tooltip" data-original-title="Delivered"><i class="fas fa-check-circle"></i></span>
                                @elseif ($data->status == "pending")
                                    <span class="text-warning" data-toggle="tooltip" data-original-title="Pending"><i class="fas fa-ellipsis-h"></i></span>
                                @elseif ($data->status == "failed" || $data->status == "FAILED")
                                    <span class="text-danger" data-toggle="tooltip" data-original-title="Failed"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </div>
                            <div class="col-3 col-sm-2 text-right text-4"> <span class="text-nowrap">@if($data->type ==1)+ @else - @endif {{$basic->currency_sym.number_format($data->amount, $basic->decimal)}}</span> <span class="text-2 text-uppercase">({{$basic->currency}})</span> </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mt-4">No Transaction Yet</div>
                @endif
            </div>
            <!-- Transaction List End -->

            <!-- Transaction Item Details Modal
            =========================================== -->
            @foreach ($trxs as $data)
                <div id="transaction-detail-{{$data->id}}" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered transaction-details" role="document">
                        <div class="modal-content">
                        <div class="modal-body">
                            <div class="row no-gutters">
                            <div class="col-sm-5 d-flex justify-content-center bg-primary rounded-left py-4">
                                <div class="my-auto text-center">
                                <div class="text-17 text-white my-3">{!! config('techplus-trx-icon.'.$data->icon) !!}</div>
                                <h3 class="text-4 text-white font-weight-400 my-3">{{$data->title}}</h3>
                                <div class="text-8 font-weight-500 text-white my-4">{{$basic->currency_sym.number_format($data->amount, $basic->decimal)}}</div>
                                <p class="text-white">{!! date('d M Y', strtotime($data->created_at)) !!}</p>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <h5 class="text-5 font-weight-400 m-3">Transaction Details
                                <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                </h5>
                                <hr>
                                <div class="px-3">
                                <ul class="list-unstyled">
                                    <li class="mb-2">Payment Amount <span class="float-right text-3">{{$basic->currency_sym.number_format($data->amount, $basic->decimal)}}</span></li>
                                    @if($data->service_type == "airtime" || $data->service_type == "internet" || $data->service_type == "tv" || $data->service_type == "electricity" || $data->service_type == "betting" || $data->service_type == "education")
                                        <li class="mb-2">Discount <span class="float-right text-3">{{$basic->currency_sym.number_format($data->discount, $basic->decimal)}}</span></li>
                                    @endif
                                    <li class="mb-2">Fee <span class="float-right text-3">{{$basic->currency_sym.number_format($data->fee, $basic->decimal)}}</span></li>
                                </ul>
                                <hr class="mb-2">
                                <p class="d-flex align-items-center font-weight-500 mb-4">Total Amount <span class="text-3 ml-auto">{{$basic->currency_sym.number_format($data->total, $basic->decimal)}}</span></p>
                                <ul class="list-unstyled">
                                    <li class="font-weight-500">Provider:</li>
                                    <li class="text-muted">{{$data->provider}}</li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li class="font-weight-500">Transaction ID:</li>
                                    <li class="text-muted">{{$data->trx}}</li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li class="font-weight-500">Description:</li>
                                    <li class="text-muted">{{$data->description}}</li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li class="font-weight-500">Date Time:</li>
                                    <li class="text-muted">{!! date('d M, Y H:i A', strtotime($data->created_at)) !!}</li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li class="font-weight-500">Status:</li>
                                    @if ($data->status == "successful" || $data->status == "SUCCESSFUL")
                                        <li class="text-muted">Successful<span class="text-success text-3 ml-1"><i class="fas fa-check-circle"></i></span></li>
                                    @elseif ($data->status == "delivered")
                                        <li class="text-muted">Delivered<span class="text-success text-3 ml-1"><i class="fas fa-check-circle"></i></span></li>
                                    @elseif ($data->status == "pending")
                                        <li class="text-muted">Pending<span class="text-warning text-3 ml-1"><i class="fas fa-ellipsis-h"></i></span></li>
                                    @elseif ($data->status == "failed" || $data->status == "FAILED")
                                        <li class="text-muted">Failed<span class="text-success text-3 ml-1"><i class="fas fa-times-circle"></i></span></li>
                                    @endif
                                </ul>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Transaction Item Details Modal End -->

            <!-- View all Link
            =============================== -->
            <div class="text-center mt-4"><a href="{{route('transactions')}}" class="btn-link text-3">View all<i class="fas fa-chevron-right text-2 ml-2"></i></a></div>
            <!-- View all Link End -->

          </div>
          <!-- Recent Activity End -->
        </div>
        <!-- Middle Panel End -->
      </div>
    </div>
  </div>

  <script>
        function copyFunc() {
            document.getElementById("cp").innerHTML = "<a href='javascript:void(0);' class='btn btn-sm btn-outline-success btn-block shadow-none'><span class='mr-1'><i class='fas fa-clone'></i></span>Account Copied</a>";
            setTimeout(function() { document.getElementById("cp").innerHTML = "<a href='javascript:void(0);' data-clipboard-text='{{auth()->user()->account_number}}' onclick='copyFunc()' class='btn btn-sm btn-outline-success btn-block shadow-none'><span class='mr-1'><i class='fas fa-clone'></i></span>Copy Account</a>"; }, 1500);
        };

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
