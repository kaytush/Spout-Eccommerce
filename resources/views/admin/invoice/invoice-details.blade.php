@extends('layouts.admindashboard')
@section('title', 'Invoice Details')

@section('content')
        <link id="skin-default" rel="stylesheet" href="{{ asset('dash/assets/css/dashlite-ver=2.4.0.css') }}" />
        <link rel="stylesheet" href="{{ asset('dash/assets/css/theme-ver=2.4.0.css') }}" />

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Invoice <strong class="text-primary small">#{{$invoice->trx}}</strong></h3>
                                        <div class="nk-block-des text-soft">
                                            <ul class="list-inline">
                                                <li>Created At: <span class="text-base">{!! date('d M, Y H:i A', strtotime($invoice->created_at)) !!}</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="{{ route('all-invoices') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                        <a href="{{ route('all-invoices') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-block">
                                <div class="invoice">
                                    <div class="invoice-action">
                                        <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="{{ route('invoice.print', $invoice->trx) }}" target="_blank"><em class="icon ni ni-printer-fill"></em></a>
                                    </div>
                                    <div class="invoice-wrap">
                                        <div class="invoice-brand text-center"><img src="{{ asset('assets/images/logo.png') }}" srcset="{{ asset('assets/images/logo.png') }} 2x" alt="" /></div>
                                        @if($invoice->status == 2)
                                            <div class="invoice-brand text-center"><a href="{{ route('approve-invoice', $invoice->trx) }}" class="btn btn-outline-primary bg-white d-sm-inline-flex"><em class="icon ni ni-wallet-saving"></em><span>Approve Now</span></a></div>
                                        @endif
                                        <div class="invoice-head">
                                            <div class="invoice-contact">
                                                <span class="overline-title">Invoice To</span>
                                                <div class="invoice-contact-info">
                                                    <h4 class="title">{{$invoice->user->firstname.' '.$invoice->user->lastname}}</h4>
                                                    <ul class="list-plain">
                                                        <li>
                                                            <em class="icon ni ni-map-pin-fill"></em>
                                                            <span>
                                                                @if($invoice->user->address){{$invoice->user->address}}@else Address N/A @endif<br />
                                                                @if($invoice->user->address){{$invoice->user->city.', '.$invoice->user->state}}@else City N/A @endif
                                                            </span>
                                                        </li>
                                                        <li><em class="icon ni ni-call-fill"></em><span>{{$invoice->user->phone}}</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="invoice-desc">
                                                <h3 class="title">Invoice</h3>
                                                <ul class="list-plain">
                                                    <li class="invoice-id"><span>Invoice ID</span>:<span>{{$invoice->trx}}</span></li>
                                                    <li class="invoice-date"><span>Date</span>:<span>{!! date('d M, Y', strtotime($invoice->created_at)) !!}</span></li>
                                                    <li class="invoice-date"><span>Status</span>:<span>@if($invoice->status ==1)<font color="green"><b>PAID</b></font> @elseif($invoice->status ==2)<font color="orange"><b>PENDING CONFIRMATION</b></font> @else <font color="red"><b>UNPAID</b></font> @endif</span></li>
                                                    <li class="invoice-id"><span>Payment By</span>:<span>{{$invoice->meth->main_name}}</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-150px">Item ID</th>
                                                            <th class="w-60">Description</th>
                                                            <th>Price</th>
                                                            <th>Qty</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{$invoice->trx}}</td>
                                                            <td>{{$invoice->details}}</td>
                                                            <td>{{$general->currency_sym}}{{number_format($invoice->amount, $general->decimal)}}</td>
                                                            <td>1</td>
                                                            <td>{{$general->currency_sym}}{{number_format($invoice->amount, $general->decimal)}}</td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td>23604094</td>
                                                            <td>6 months premium support</td>
                                                            <td>$78.75</td>
                                                            <td>1</td>
                                                            <td>$78.75</td>
                                                        </tr> --}}
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">Subtotal</td>
                                                            <td>{{$general->currency_sym}}{{number_format($invoice->amount, $general->decimal)}}</td>
                                                        </tr>
                                                        @if($invoice->addfee_amount > 0)
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">{{$invoice->addfee_name}}</td>
                                                                <td>{{$general->currency_sym}}{{number_format($invoice->addfee_amount, $general->decimal)}}</td>
                                                            </tr>
                                                        @endif
                                                        @if($invoice->method == 2)
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">Stamp Duty</td>
                                                                <td>{{$general->currency_sym}}{{number_format($invoice->stampduty, $general->decimal)}}</td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">VAT</td>
                                                            <td>{{$general->currency_sym}}{{number_format($invoice->vat, $general->decimal)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">Grand Total</td>
                                                            <td>{{$general->currency_sym}}{{number_format($invoice->total, $general->decimal)}}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="nk-notes ff-italic fs-12px text-soft">Invoice was created on a computer and is valid without the signature and seal.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

@endsection
