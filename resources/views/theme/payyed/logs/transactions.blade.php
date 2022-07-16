@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

        <!-- Content
        ============================================= -->
        <div id="content" class="py-4">
            <div class="container">
                <div class="row">
                    @include('theme.'.$basic->theme.'.layouts.leftpanel')
                    <!-- Middle Panel
                ============================================= -->
                    <div class="col-lg-9">
                        <h2 class="font-weight-400 mb-3">Transactions</h2>

                        <!-- All Transactions
                ============================================= -->
                        <div class="bg-white shadow-sm rounded py-4 mb-4">
                            <h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-4">All Transactions</h3>
                            <!-- Title
                    =============================== -->
                            <div class="transaction-title py-2 px-4">
                                <div class="row">
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

                            @include('theme.'.$basic->theme.'.pagination.default', ['paginator' => $trxs])

                        </div>
                        <!-- All Transactions End -->
                    </div>
                    <!-- Middle End -->
                </div>
            </div>
        </div>
        <!-- Content end -->

@endsection
