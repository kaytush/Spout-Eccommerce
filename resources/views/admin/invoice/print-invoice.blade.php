<!DOCTYPE html>
<html lang="zxx" class="js">
    <head>
        <meta charset="utf-8" />
        <meta name="author" content="{{$basic->sitename}}" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{$basic->sitename}}" />
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
        <title>{{ config('app.name', $basic->sitename) }} | @yield('title', 'Invoice'))</title>
        <link rel="stylesheet" href="{{ asset('dash/assets/css/dashlite-ver=2.4.0.css') }}" />
        <link id="skin-default" rel="stylesheet" href="{{ asset('dash/assets/css/theme-ver=2.4.0.css') }}" />
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA--4"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());
            gtag("config", "UA--4");
        </script>
    </head>
    <body class="bg-white" onload="printPromot()">
        <div class="nk-block">
            <div class="invoice invoice-print">
                <div class="invoice-wrap">
                    <div class="invoice-brand text-center"><img src="{{ asset('assets/images/logo.png') }}" srcset="{{ asset('assets/images/logo.png') }} 2x" alt="" /></div>
                    <div class="invoice-head">
                        <div class="invoice-contact">
                            <span class="overline-title">Invoice To</span>
                            <div class="invoice-contact-info">
                                <h4 class="title">{{$invoice->user->firstname.' '.$invoice->user->lastname}}</h4>
                                <ul class="list-plain">
                                    <li>
                                        <em class="icon ni ni-map-pin-fill fs-18px"></em>
                                        <span>
                                            @if($invoice->user->address){{$invoice->user->address}}@else Address N/A @endif<br />
                                            @if($invoice->user->address){{$invoice->user->city.', '.$invoice->user->state}}@else City N/A @endif
                                        </span>
                                    </li>
                                    <li><em class="icon ni ni-call-fill fs-14px"></em><span>{{$invoice->user->phone}}</span></li>
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
                                        <td>24108054</td>
                                        <td>6 months premium support</td>
                                        <td>$25.00</td>
                                        <td>1</td>
                                        <td>$25.00</td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function printPromot() {
                window.print();
            }
        </script>
    </body>
</html>
