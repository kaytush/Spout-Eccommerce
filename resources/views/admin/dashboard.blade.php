@extends('layouts.admindashboard')
@section('title', 'Control Dashboard')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">@yield('title')</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>Welcome to {{$basic->sitename}} Control Dashboard.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    {{-- <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                                    <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-reports"></em><span>Reports</span></a></li> --}}
                                                    <li class="nk-block-tools-opt">
                                                        <div class="drodown">
                                                            <button type="button" onclick="window.print();" class="dropdown-toggle btn btn-icon btn-primary"><em class="icon ni ni-printer-fill"></em></button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div><!-- .toggle-expand-content -->
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <div class="col-md-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="subtitle">Total Invoice</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Deposited"></em>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount"> {{number_format($inv_year, $basic->decimal)}} <span class="currency currency-usd">{{$basic->currency}}</span>
                                                    </span>
                                                    <span class="change up text-danger">This Year</span>
                                                </div>
                                                <br>
                                                <div class="invest-data">
                                                    <div class="invest-data-amount g-2">
                                                        <div class="invest-data-history">
                                                            <div class="title">This Month</div>
                                                            <div class="amount"><span class="currency currency-usd">{{$basic->currency_sym}}</span>{{number_format($inv_month, $basic->decimal)}}</div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">This Week</div>
                                                            <div class="amount"><span class="currency currency-usd">{{$basic->currency_sym}}</span>{{number_format($inv_week, $basic->decimal)}}</div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">Today</div>
                                                            <div class="amount"><span class="currency currency-usd">{{$basic->currency_sym}}</span>{{number_format($inv_today, $basic->decimal)}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="subtitle">Total Subscription</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Withdraw"></em>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount"> {{number_format($sub_year, $basic->decimal)}} <span class="currency currency-usd">{{$basic->currency}}</span>
                                                    </span>
                                                    <span class="change up text-danger">This Year</span>
                                                </div>
                                                <br>
                                                <div class="invest-data">
                                                    <div class="invest-data-amount g-2">
                                                        <div class="invest-data-history">
                                                            <div class="title">This Month</div>
                                                            <div class="amount"><span class="currency currency-usd">{{$basic->currency_sym}}</span>{{number_format($sub_month, $basic->decimal)}}</div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">This Week</div>
                                                            <div class="amount"><span class="currency currency-usd">{{$basic->currency_sym}}</span>{{number_format($sub_week, $basic->decimal)}}</div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">Today</div>
                                                            <div class="amount"><span class="currency currency-usd">{{$basic->currency_sym}}</span>{{number_format($sub_today, $basic->decimal)}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered  card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="subtitle">Total Service Order</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Balance in Account"></em>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount">{{$ord_year}}</span>
                                                    <span class="change up text-danger">This Year</span>
                                                </div>
                                                <br>
                                                <div class="invest-data">
                                                    <div class="invest-data-amount g-2">
                                                        <div class="invest-data-history">
                                                            <div class="title">This Month</div>
                                                            <div class="amount">{{$ord_month}}</div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">This Week</div>
                                                            <div class="amount">{{$ord_week}}</div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">Today</div>
                                                            <div class="amount">{{$ord_today}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    {{-- monthly --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-dark card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Invoice Paid <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($p_inv_month, $basic->decimal)}} <span class="change up">this month</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s1 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Subscription Paid <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($p_sub_month, $basic->decimal)}} <span class="change up">this month</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s3 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Paid Order <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$p_ord_month}} <span class="change up">this month</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    {{-- weekly --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-dark card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Invoice Paid <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($p_inv_week, $basic->decimal)}} <span class="change up">this week</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s1 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Subscription Paid <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($p_sub_week, $basic->decimal)}} <span class="change up">this week</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s3 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Paid Order <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$p_ord_week}} <span class="change up">this week</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    {{-- Airtime --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-dark card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Airtime Order <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($airtime_sum_amount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s1 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Airtime Discount <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($airtime_sum_discount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s3 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Airtime Count <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$airtime_t_count}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    {{-- Airtime --}}
                                    {{-- Internet Data --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-dark card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Internet Data Order <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($internet_sum_amount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s1 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Internet Data Discount <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($internet_sum_discount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s3 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Internet Data Count <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$internet_t_count}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    {{-- Internet Data --}}
                                    {{-- CableTV --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-dark card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total CableTV Order <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($tv_sum_amount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s1 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total CableTV Discount <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($tv_sum_discount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s3 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total CableTV Count <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$tv_t_count}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    {{-- CableTV --}}
                                    {{-- Electricity --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-dark card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Electricity Order <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($electricity_sum_amount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s1 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Electricity Discount <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($electricity_sum_discount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s3 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Electricity Count <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$electricity_t_count}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    {{-- Electricity --}}
                                    {{-- Betting --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-dark card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Betting Order <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($betting_sum_amount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s1 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Betting Discount <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount">{{$basic->currency_sym}} {{number_format($betting_sum_discount, $basic->decimal)}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s3 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Total Betting Count <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$betting_t_count}} <span class="change up">all time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    {{-- Betting --}}
                                    {{-- Services Order Details --}}
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-dark card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Service Requests <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$service_pending}} <span class="change up">total</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nk-wg-card is-s1 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Service In Progress <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$service_inprogress}} <span class="change up">total</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-12 col-lg-4">
                                        <div class="nk-wg-card is-s3 card card-bordered">
                                            <div class="card-inner">
                                                <div class="nk-iv-wg2">
                                                    <div class="nk-iv-wg2-title">
                                                        <h6 class="title">Service Completed <em class="icon ni ni-info"></em></h6>
                                                    </div>
                                                    <div class="nk-iv-wg2-text">
                                                        <div class="nk-iv-wg2-amount"> {{$service_completed}} <span class="change up">total</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-12 col-xxl-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner d-flex flex-column h-100">
                                                <div class="card-title-group mb-3">
                                                    <div class="card-title">
                                                        <h6 class="title">Top Subscribed Plans</h6>
                                                        <p>{{date('M, Y')}} top (5) subscribed plans.</p>
                                                    </div>
                                                    <div class="card-tools mt-n4 mr-n1">
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="javascript:void(0);" class="active"><span>{{date('M, Y')}}</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="progress-list gy-3">
                                                        @php
                                                        $max_show=5;
                                                        $show=0;
                                                        rsort($sub_counts);
                                                        @endphp
                                                    @foreach ($sub_counts as $key => $val)
                                                        @php
                                                            $call = \App\Models\Invoice::whereYear('created_at', Carbon\Carbon::now()->year)->whereMonth('created_at', Carbon\Carbon::now()->month)->where('plan_id', !NULL)->whereStatus(1)->count();
                                                        @endphp
                                                        @if($show < $max_show)
                                                            <div class="progress-wrap">
                                                                <div class="progress-text">
                                                                    <div class="progress-label">{{$sub_names[$key*1]}} Plan</div>
                                                                    @if ($call > 0)
                                                                        <div class="progress-amount">{{($val / ($call+1)) * 100}}%</div>
                                                                    @else
                                                                        <div class="progress-amount">0%</div>
                                                                    @endif
                                                                </div>
                                                                <div class="progress progress-md">
                                                                    @if ($call > 0)
                                                                        <div class="progress-bar @if((($val / ($call+1)) * 100) > 75) bg-teal @elseif((($val / ($call+1)) * 100) > 50 && (($val / ($call+1)) * 100) < 76) @elseif((($val / ($call+1)) * 100) > 25 && (($val / ($call+1)) * 100) < 51) bg-orange @elseif((($val / ($call+1)) * 100) < 26) bg-pink @endif" data-progress="{{($val / ($call+1)) * 100}}"></div>
                                                                    @else
                                                                        <div class="progress-bar" data-progress="0"></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-xxl-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Recent User Logins</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <ul class="card-tools-nav">
                                                            <li class="active"><a href="javascript:void(0);"><span>latest 5</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nk-activity">
                                                @foreach ($recent_user_logins as $data)
                                                    <li class="nk-activity-item">
                                                        <div class="nk-activity-media user-avatar bg-success">
                                                            @if(file_exists($data->user->image))
                                                                <img src="{{url($data->user->image)}}" alt="">
                                                            @else
                                                                <img src="{{url('assets/images/profile.png')}}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="nk-activity-data">
                                                            <div class="label"><b>{{$data->user->firstname.' '.$data->user->lastname}}</b> login {{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</div>
                                                            <span class="time">from {{$data->location}} @if($data->location == "Unknown") location @endif</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-6 col-xxl-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Recent Transactions</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <ul class="card-tools-nav">
                                                            <li class="active"><a href="javascript:void(0);"><span>latest 5</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nk-activity">
                                                @foreach ($transactions as $data)
                                                    <li class="nk-activity-item">
                                                        <div class="nk-activity-media user-avatar bg-success">
                                                            @if($data->type ==1)
                                                                <img src="{{url('assets/images/icons/icon-11.png')}}" alt="">
                                                            @else
                                                                <img src="{{url('assets/images/icons/icon-9.png')}}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="nk-activity-data">
                                                            <div class="label">{{$data->title}} <b>({{$basic->currency_sym.number_format($data->amount,$basic->decimal)}})</b> - {{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }} | {!! date(' M d, Y H:i A', strtotime($data->created_at)) !!}</div>
                                                            <span class="time">{{$data->description}}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

@endsection
