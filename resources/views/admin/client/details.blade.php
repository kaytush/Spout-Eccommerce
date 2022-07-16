@extends('layouts.admindashboard')
@section('title', 'Client Details')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Client / <strong class="text-primary small">{{$client->firstname.' '.$client->lastname}}</strong></h3>
                                        <div class="nk-block-des text-soft">
                                            <ul class="list-inline">
                                                <li>User ID: <span class="text-base">{{$client->id}}</span></li>
                                                <li>Last Login: <span class="text-base">@if($lastlogin === NULL)N/A @else {!! date(' d M, Y h:i A', strtotime($lastlogin->created_at)) !!} @endif</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="{{ route('clients') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                        <a href="{{ route('clients') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered">
                                    <div class="card-aside-wrap">
                                        <div class="card-content">
                                            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#tabItem1"><em class="icon ni ni-user-circle"></em><span>Personal</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem2"><em class="icon ni ni-repeat"></em><span>Transactions</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem3"><em class="icon ni ni-wallet-saving"></em><span>Deposits</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem4"><em class="icon ni ni-wallet-saving"></em><span>Withdrawals</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem5"><em class="icon ni ni-file-text"></em><span>Bill History</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem6"><em class="icon ni ni-mail"></em><span>Message History</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem7"><em class="icon ni ni-activity"></em><span>Activities</span></a>
                                                </li>
                                                <li class="nav-item nav-item-trigger d-xxl-none">
                                                    <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                                </li>
                                            </ul><!-- .nav-tabs -->
                                            <div class="card-inner">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tabItem1">
                                                        <div class="nk-block">
                                                            <div class="nk-block-head">
                                                                <h5 class="title">Personal Information</h5>
                                                                <p>Client Basic Information.</p>
                                                            </div><!-- .nk-block-head -->
                                                            <div class="profile-ud-list">
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">First Name</span>
                                                                        <span class="profile-ud-value">{{$client->firstname}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Last Name</span>
                                                                        <span class="profile-ud-value">{{$client->lastname}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Email</span>
                                                                        <span class="profile-ud-value">{{$client->email}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Phone Number</span>
                                                                        <span class="profile-ud-value">{{$client->phone}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Username</span>
                                                                        <span class="profile-ud-value">{{$client->username}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Level/User Type</span>
                                                                        <span class="profile-ud-value">@if($client->level == 1) Reseller/Agent @elseif($client->level == 0) Client @endif</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Date of Birth</span>
                                                                        <span class="profile-ud-value">@if($client->dob !=NULL){!! date(' M d, Y', strtotime($client->dob)) !!}@else N/A @endif</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">State</span>
                                                                        <span class="profile-ud-value">@if($client->state !=NULL){{$client->state}}@else N/A @endif</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">City</span>
                                                                        <span class="profile-ud-value">@if($client->city !=NULL){{$client->city}}@else N/A @endif</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Address</span>
                                                                        <span class="profile-ud-value">@if($client->address !=NULL){{$client->address}}@else N/A @endif</span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- .profile-ud-list -->
                                                        </div><!-- .nk-block -->
                                                        <div class="nk-block">
                                                            <div class="nk-block-head nk-block-head-line">
                                                                <h6 class="title overline-title text-base">Additional Information</h6>
                                                            </div><!-- .nk-block-head -->
                                                            <div class="profile-ud-list">
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Date Joined</span>
                                                                        <span class="profile-ud-value">{!! date(' M d, Y H:i A', strtotime($client->created_at)) !!}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Email Verification</span>
                                                                        @if($client->email_verified ==1)
                                                                            <span class="profile-ud-value">Verified</span>
                                                                        @else
                                                                            <span class="profile-ud-value">Not Verified</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div><!-- .profile-ud-list -->
                                                            <div class="profile-ud-list">
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Nuban Account</span>
                                                                        @if($client->acc_status ==1)
                                                                            <span class="profile-ud-value">Generated</span>
                                                                        @else
                                                                            <span class="profile-ud-value">Not Generated</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">BVN Verification</span>
                                                                        @if($client->bvn_status ==1)
                                                                            <span class="profile-ud-value">Verified</span>
                                                                        @elseif($client->bvn_status ==2)
                                                                            <span class="profile-ud-value">Verifying</span>
                                                                        @else
                                                                            <span class="profile-ud-value">Not Verified</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div><!-- .profile-ud-list -->
                                                            @if($client->acc_status ==1)
                                                                @php
                                                                    $acc = \App\Models\Nuban::where('customer_code', $client->pk_customer_code)->first();
                                                                @endphp
                                                                <div class="profile-ud-list">
                                                                    <div class="profile-ud-item">
                                                                        <div class="profile-ud wider">
                                                                            <span class="profile-ud-label">Account Number</span>
                                                                                <span class="profile-ud-value">{{ $acc->account_number }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="profile-ud-item">
                                                                        <div class="profile-ud wider">
                                                                            <span class="profile-ud-label">Bank</span>
                                                                                <span class="profile-ud-value">{{ $acc->bank_name }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- .profile-ud-list -->
                                                            @endif
                                                        </div><!-- .nk-block -->
                                                        <div class="nk-divider divider md"></div>
                                                    </div>
                                                    <div class="tab-pane" id="tabItem2">
                                                        <div class="nk-block">
                                                            <div class="card card-bordered card-stretch">
                                                                <div class="card-inner-group">
                                                                    <div class="card-inner">
                                                                        <div class="card-title-group">
                                                                            <div class="card-title">
                                                                                <h5 class="title">All Transactions</h5>
                                                                            </div>
                                                                        </div><!-- .card-title-group -->
                                                                    </div><!-- .card-inner -->
                                                                    <div class="card-inner p-0">
                                                                        <table class="table table-tranx">
                                                                            <thead>
                                                                                <tr class="tb-tnx-head">
                                                                                    <th class="tb-tnx-info">
                                                                                        <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                                                            <span>Title</span>
                                                                                        </span>
                                                                                        <span class="tb-tnx-date d-md-inline-block d-none">
                                                                                            <span class="d-md-none">Date</span>
                                                                                            <span class="d-none d-md-block">
                                                                                                <span>Trans.No</span>
                                                                                                <span>Date</span>
                                                                                            </span>
                                                                                        </span>
                                                                                    </th>
                                                                                    <th class="tb-tnx-id"><span class="">Type</span></th>
                                                                                    <th class="tb-tnx-amount is-alt">
                                                                                        <span class="tb-tnx-total">Amount</span>
                                                                                        <span class="tb-tnx-status d-none d-md-inline-block">Service</span>
                                                                                    </th>
                                                                                </tr><!-- tb-tnx-item -->
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($transactions as $key => $data)
                                                                                    <tr class="tb-tnx-item">
                                                                                        <td class="tb-tnx-info">
                                                                                            <div class="tb-tnx-desc">
                                                                                                <span class="title">{{$data->title}}</span><br>
                                                                                                <span class="">{{$data->description}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-date">
                                                                                                <span class="date">{{$data->trx}}</span>
                                                                                                <span class="date">{!! date(' d-m-Y h:iA', strtotime($data->updated_at)) !!}</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="tb-tnx-id">
                                                                                            <span>@if($data->type == 1) <font color="green">Credit</font> @elseif($data->type == 0) <font color="red">Debit</font> @endif</span>
                                                                                        </td>
                                                                                        <td class="tb-tnx-amount is-alt">
                                                                                            <div class="tb-tnx-total">
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->amount, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-status">
                                                                                                @if($data->service == "deposit" || $data->service == "balance" || $data->service == "earning" || $data->service == "cashback")
                                                                                                    <span class="badge badge-dot badge-success">{{$data->service}}</span>
                                                                                                @elseif($data->service == "bills" || $data->service == "sms")
                                                                                                    <span class="badge badge-dot badge-danger">{{$data->service}}</span>
                                                                                                @elseif($data->service == "gift" || $data->service == "deals")
                                                                                                    <span class="badge badge-dot badge-warning">{{$data->service}}</span>
                                                                                                @else
                                                                                                    <span class="badge badge-dot badge-primary">{{$data->service}}</span>
                                                                                                @endif
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr><!-- tb-tnx-item -->
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- .card-inner -->
                                                                </div><!-- .card-inner-group -->
                                                            </div><!-- .card -->
                                                        </div><!-- .nk-block -->
                                                    </div>
                                                    <div class="tab-pane" id="tabItem3">
                                                        <div class="nk-block">
                                                            <div class="card card-bordered card-stretch">
                                                                <div class="card-inner-group">
                                                                    <div class="card-inner">
                                                                        <div class="card-title-group">
                                                                            <div class="card-title">
                                                                                <h5 class="title">All Deposits</h5>
                                                                            </div>
                                                                        </div><!-- .card-title-group -->
                                                                    </div><!-- .card-inner -->
                                                                    <div class="card-inner p-0">
                                                                        <table class="table table-tranx">
                                                                            <thead>
                                                                                <tr class="tb-tnx-head">
                                                                                    <th class="tb-tnx-id"><span class="">#</span></th>
                                                                                    <th class="tb-tnx-info">
                                                                                        <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                                                            <span class="d-md-none">Date</span>
                                                                                            <span>Bill For</span>
                                                                                        </span>
                                                                                        <span class="tb-tnx-date d-md-inline-block d-none">
                                                                                            <span class="d-md-none">Date</span>
                                                                                            <span class="d-none d-md-block">
                                                                                                <span>Amount</span>
                                                                                                <span>Fee</span>
                                                                                            </span>
                                                                                        </span>
                                                                                    </th>
                                                                                    <th class="tb-tnx-amount is-alt">
                                                                                        <span class="tb-tnx-total">Total</span>
                                                                                        <span class="tb-tnx-status d-none d-md-inline-block">Status</span>
                                                                                    </th>
                                                                                </tr><!-- tb-tnx-item -->
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($deposits as $key => $data)
                                                                                    <tr class="tb-tnx-item">
                                                                                        <td class="tb-tnx-id">
                                                                                            <a href="javascript:void()"><span>{{$data->trx}}</span></a>
                                                                                            <span>{!! date('d M Y, H:i a', strtotime($data->created_at)) !!}</span>
                                                                                        </td>
                                                                                        <td class="tb-tnx-info">
                                                                                            <div class="tb-tnx-desc">
                                                                                                <span class="title">{{$data->gate->name}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-date">
                                                                                                <span class="date">{{$basic->currency_sym}}{{number_format($data->amount, $basic->decimal)}}</span>
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->fee, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="tb-tnx-amount is-alt">
                                                                                            <div class="tb-tnx-total">
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->total_amount, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-status">
                                                                                                @if($data->status == 1)
                                                                                                    <span class="badge badge-dot badge-success">Paid</span>
                                                                                                @elseif($data->status == 0)
                                                                                                    <span class="badge badge-dot badge-warning">Unpaid</span>
                                                                                                    <span class="badge badge-dot badge-primary"><a href="{{ route('mconfirm-flpayment', [$data->trx]) }}">Approve</a></span>
                                                                                                @elseif($data->status == 2)
                                                                                                    <span class="badge badge-dot badge-primary">Pending Confirmation</span>
                                                                                                @endif
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr><!-- tb-tnx-item -->
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- .card-inner -->
                                                                </div><!-- .card-inner-group -->
                                                            </div><!-- .card -->
                                                        </div><!-- .nk-block -->
                                                    </div>
                                                    <div class="tab-pane" id="tabItem4">
                                                        <div class="nk-block">
                                                            <div class="card card-bordered card-stretch">
                                                                <div class="card-inner-group">
                                                                    <div class="card-inner">
                                                                        <div class="card-title-group">
                                                                            <div class="card-title">
                                                                                <h5 class="title">All Withdrawals</h5>
                                                                            </div>
                                                                        </div><!-- .card-title-group -->
                                                                    </div><!-- .card-inner -->
                                                                    <div class="card-inner p-0">
                                                                        <table class="table table-tranx">
                                                                            <thead>
                                                                                <tr class="tb-tnx-head">
                                                                                    <th class="tb-tnx-id"><span class="">#</span></th>
                                                                                    <th class="tb-tnx-info">
                                                                                        <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                                                            <span>Bill For</span>
                                                                                        </span>
                                                                                        <span class="tb-tnx-date d-md-inline-block d-none">
                                                                                            <span class="d-md-none">Date</span>
                                                                                            <span class="d-none d-md-block">
                                                                                                <span>Issue Date</span>
                                                                                                <span>Amount</span>
                                                                                            </span>
                                                                                        </span>
                                                                                    </th>
                                                                                    <th class="tb-tnx-amount is-alt">
                                                                                        <span class="tb-tnx-total">Total</span>
                                                                                        <span class="tb-tnx-status d-none d-md-inline-block">Status</span>
                                                                                    </th>
                                                                                </tr><!-- tb-tnx-item -->
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($invoices as $key => $data)
                                                                                    <tr class="tb-tnx-item">
                                                                                        <td class="tb-tnx-id">
                                                                                            <a href="#"><span>{{$data->trx}}</span></a>
                                                                                        </td>
                                                                                        <td class="tb-tnx-info">
                                                                                            <div class="tb-tnx-desc">
                                                                                                <span class="title">{{$data->details}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-date">
                                                                                                <span class="date">{!! date(' d-m-Y', strtotime($data->created_at)) !!}</span>
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->amount, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="tb-tnx-amount is-alt">
                                                                                            <div class="tb-tnx-total">
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->total, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-status">
                                                                                                @if($data->status == 1)
                                                                                                    <span class="badge badge-dot badge-success">Paid</span>
                                                                                                @elseif($data->status == 0)
                                                                                                    <span class="badge badge-dot badge-warning">Unpaid</span>
                                                                                                @elseif($data->status == 2)
                                                                                                    <span class="badge badge-dot badge-primary">Pending Confirmation</span>
                                                                                                @endif
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr><!-- tb-tnx-item -->
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- .card-inner -->
                                                                </div><!-- .card-inner-group -->
                                                            </div><!-- .card -->
                                                        </div><!-- .nk-block -->
                                                    </div>
                                                    <div class="tab-pane" id="tabItem5">
                                                        <div class="nk-block">
                                                            <div class="card card-bordered card-stretch">
                                                                <div class="card-inner p-0">
                                                                    <div class="card-inner">
                                                                        <div class="card-title-group">
                                                                            <div class="card-title">
                                                                                <h5 class="title">All Bills</h5>
                                                                            </div>
                                                                        </div><!-- .card-title-group -->
                                                                    </div><!-- .card-inner -->
                                                                    <div class="nk-tb-list nk-tb-tnx">
                                                                        <div class="nk-tb-item nk-tb-head">
                                                                            <div class="nk-tb-col"><span>Details</span></div>
                                                                            <div class="nk-tb-col tb-col-xxl"><span>Source</span></div>
                                                                            <div class="nk-tb-col tb-col-lg"><span>Order</span></div>
                                                                            <div class="nk-tb-col text-right"><span>Amount</span></div>
                                                                            <div class="nk-tb-col text-right tb-col-sm"><span>Balance</span></div>
                                                                            <div class="nk-tb-col nk-tb-col-status"><span class="sub-text d-none d-md-block">Status</span></div>
                                                                            <div class="nk-tb-col nk-tb-col-tools"></div>
                                                                        </div><!-- .nk-tb-item -->
                                                                        @foreach($bills as $key => $data)
                                                                            <div class="nk-tb-item">
                                                                                <div class="nk-tb-col">
                                                                                    <div class="nk-tnx-type">
                                                                                        @if($data->status =="SUCCESS" || $data->status =="successful" || $data->status =="delivered")
                                                                                            <div class="nk-tnx-type-icon bg-success-dim text-success">
                                                                                                <em class="icon ni ni-arrow-up-right"></em>
                                                                                            </div>
                                                                                        @elseif($data->status =="PENDING")
                                                                                            <div class="nk-tnx-type-icon bg-info-dim text-info">
                                                                                                <em class="icon ni ni-arrow-up-right"></em>
                                                                                            </div>
                                                                                        @elseif($data->status =="FAIL" || $data->status =="failed" || $data->status =="FAILED")
                                                                                            <div class="nk-tnx-type-icon bg-danger-dim text-danger">
                                                                                                <em class="icon ni ni-arrow-down-left"></em>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="nk-tnx-type-icon bg-warning-dim text-warning">
                                                                                                <em class="icon ni ni-arrow-up-right"></em>
                                                                                            </div>
                                                                                        @endif
                                                                                        <div class="nk-tnx-type-text">
                                                                                            <span class="tb-lead">{{$data->provider}} - {{$data->recipient}}</span>
                                                                                            <span class="tb-date">{!! date('d M Y, H:i a', strtotime($data->updated_at)) !!}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="nk-tb-col tb-col-xxl">
                                                                                    <span class="tb-lead-sub">{{$data->provider}} - {{$data->recipient}}</span>
                                                                                    <span class="tb-sub">{!! date('d M Y, H:i a', strtotime($data->updated_at)) !!}</span>
                                                                                </div>
                                                                                <div class="nk-tb-col tb-col-lg">
                                                                                    <span class="tb-lead-sub">{{$data->trx}}</span>
                                                                                    <span class="badge badge-dot badge-success">{{$data->service_type}} - {{$data->channel}} - {{$data->ref}}</span>
                                                                                </div>
                                                                                <div class="nk-tb-col text-right">
                                                                                    <span class="tb-amount">{{$general->currency_sym}}{{number_format($data->amount, $general->decimal)}} <span>Amount</span></span>
                                                                                    <span class="tb-amount-sm">{{$general->currency_sym}}{{number_format($data->paid, $general->decimal)}} Paid</span>
                                                                                </div>
                                                                                <div class="nk-tb-col text-right tb-col-sm">
                                                                                    <span class="tb-amount">{{$general->currency_sym}}{{number_format($data->init_bal, $general->decimal)}} <span>INT</span></span>
                                                                                    <span class="tb-amount-sm">{{$general->currency_sym}}{{number_format($data->new_bal, $general->decimal)}} NEW</span>
                                                                                </div>
                                                                                @if($data->status =="SUCCESS" || $data->status =="successful" || $data->status =="delivered")
                                                                                    <div class="nk-tb-col nk-tb-col-status">
                                                                                        <div class="dot dot-success d-md-none"></div>
                                                                                        <span class="badge badge-sm badge-dim badge-outline-success d-none d-md-inline-flex">{{$data->status}}</span>
                                                                                    </div>
                                                                                @elseif($data->status =="PENDING")
                                                                                    <div class="nk-tb-col nk-tb-col-status">
                                                                                        <div class="dot dot-info d-md-none"></div>
                                                                                        <span class="badge badge-sm badge-dim badge-outline-info d-none d-md-inline-flex">{{$data->status}}</span>
                                                                                    </div>
                                                                                @elseif($data->status =="FAIL" || $data->status =="failed" || $data->status =="FAILED")
                                                                                    <div class="nk-tb-col nk-tb-col-status">
                                                                                        <div class="dot dot-danger d-md-none"></div>
                                                                                        <span class="badge badge-sm badge-dim badge-outline-danger d-none d-md-inline-flex">{{$data->status}}</span>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="nk-tb-col nk-tb-col-status">
                                                                                        <div class="dot dot-warning d-md-none"></div>
                                                                                        <span class="badge badge-sm badge-dim badge-outline-warning d-none d-md-inline-flex">{{$data->status}}</span>
                                                                                    </div>
                                                                                @endif
                                                                                <div class="nk-tb-col nk-tb-col-tools">
                                                                                    <ul class="nk-tb-actions gx-2">
                                                                                        @if($data->status =="PENDING" || $data->status =="FAIL" || $data->status =="failed" || $data->status =="FAILED")
                                                                                            @if($data->refunded == 0)
                                                                                                <li class="nk-tb-action-hidden">
                                                                                                    <a href="{{ route('refund-client-bill', [$data->id]) }}" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="Refund"><em class="icon ni ni-repeat"></em></a>
                                                                                                </li>
                                                                                            @endif
                                                                                        @endif
                                                                                        <li class="nk-tb-action-hidden">
                                                                                            <a href="#tranxDetails-{{$data->id}}" data-toggle="modal" class="bg-white btn btn-sm btn-outline-light btn-icon btn-tooltip" title="Details"><em class="icon ni ni-eye"></em></a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <div class="dropdown">
                                                                                                <a href="#" class="dropdown-toggle bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                    <ul class="link-list-opt">
                                                                                                        @if($data->service_type == "betting")
                                                                                                            <li><a href="{{ route('check-betting-status', [$data->ref, $data->trx]) }}"><em class="icon ni ni-done"></em><span>Check Status</span></a></li>
                                                                                                        @endif
                                                                                                        @if($data->service_type == "internet")
                                                                                                            <li><a href="{{ route('check-internet-status', [$data->ref, $data->trx]) }}"><em class="icon ni ni-done"></em><span>Check Status</span></a></li>
                                                                                                        @endif
                                                                                                        {{-- <li><a href="#"><em class="icon ni ni-cross-round"></em><span>Reject</span></a></li> --}}
                                                                                                        @if($data->status =="PENDING" || $data->status =="FAIL" || $data->status =="failed" || $data->status =="FAILED")
                                                                                                            @if($data->refunded == 0)
                                                                                                                <li><a href="{{ route('refund-client-bill', [$data->id]) }}"><em class="icon ni ni-repeat"></em><span>Refund</span></a></li>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                        <li><a href="#tranxDetails-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div><!-- .nk-tb-item -->
                                                                        @endforeach
                                                                    </div><!-- .nk-tb-list -->
                                                                </div><!-- .card-inner -->
                                                            </div><!-- .card -->
                                                        </div><!-- .nk-block -->
                                                    </div>
                                                    <div class="tab-pane" id="tabItem6">
                                                        <div class="nk-block">
                                                            <div class="card card-bordered card-stretch">
                                                                <div class="card-inner-group">
                                                                    <div class="card-inner">
                                                                        <div class="card-title-group">
                                                                            <div class="card-title">
                                                                                <h5 class="title">All Invoices</h5>
                                                                            </div>
                                                                        </div><!-- .card-title-group -->
                                                                    </div><!-- .card-inner -->
                                                                    <div class="card-inner p-0">
                                                                        <table class="table table-tranx">
                                                                            <thead>
                                                                                <tr class="tb-tnx-head">
                                                                                    <th class="tb-tnx-id"><span class="">#</span></th>
                                                                                    <th class="tb-tnx-info">
                                                                                        <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                                                            <span>Bill For</span>
                                                                                        </span>
                                                                                        <span class="tb-tnx-date d-md-inline-block d-none">
                                                                                            <span class="d-md-none">Date</span>
                                                                                            <span class="d-none d-md-block">
                                                                                                <span>Issue Date</span>
                                                                                                <span>Amount</span>
                                                                                            </span>
                                                                                        </span>
                                                                                    </th>
                                                                                    <th class="tb-tnx-amount is-alt">
                                                                                        <span class="tb-tnx-total">Total</span>
                                                                                        <span class="tb-tnx-status d-none d-md-inline-block">Status</span>
                                                                                    </th>
                                                                                </tr><!-- tb-tnx-item -->
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($invoices as $key => $data)
                                                                                    <tr class="tb-tnx-item">
                                                                                        <td class="tb-tnx-id">
                                                                                            <a href="#"><span>{{$data->trx}}</span></a>
                                                                                        </td>
                                                                                        <td class="tb-tnx-info">
                                                                                            <div class="tb-tnx-desc">
                                                                                                <span class="title">{{$data->details}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-date">
                                                                                                <span class="date">{!! date(' d-m-Y', strtotime($data->created_at)) !!}</span>
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->amount, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="tb-tnx-amount is-alt">
                                                                                            <div class="tb-tnx-total">
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->total, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-status">
                                                                                                @if($data->status == 1)
                                                                                                    <span class="badge badge-dot badge-success">Paid</span>
                                                                                                @elseif($data->status == 0)
                                                                                                    <span class="badge badge-dot badge-warning">Unpaid</span>
                                                                                                @elseif($data->status == 2)
                                                                                                    <span class="badge badge-dot badge-primary">Pending Confirmation</span>
                                                                                                @endif
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr><!-- tb-tnx-item -->
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- .card-inner -->
                                                                </div><!-- .card-inner-group -->
                                                            </div><!-- .card -->
                                                        </div><!-- .nk-block -->
                                                    </div>
                                                    <div class="tab-pane" id="tabItem7">
                                                        <div class="nk-block">
                                                            <div class="card card-bordered card-stretch">
                                                                <div class="card-inner-group">
                                                                    <div class="card-inner">
                                                                        <div class="card-title-group">
                                                                            <div class="card-title">
                                                                                <h5 class="title">All Invoices</h5>
                                                                            </div>
                                                                        </div><!-- .card-title-group -->
                                                                    </div><!-- .card-inner -->
                                                                    <div class="card-inner p-0">
                                                                        <table class="table table-tranx">
                                                                            <thead>
                                                                                <tr class="tb-tnx-head">
                                                                                    <th class="tb-tnx-id"><span class="">#</span></th>
                                                                                    <th class="tb-tnx-info">
                                                                                        <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                                                            <span>Bill For</span>
                                                                                        </span>
                                                                                        <span class="tb-tnx-date d-md-inline-block d-none">
                                                                                            <span class="d-md-none">Date</span>
                                                                                            <span class="d-none d-md-block">
                                                                                                <span>Issue Date</span>
                                                                                                <span>Amount</span>
                                                                                            </span>
                                                                                        </span>
                                                                                    </th>
                                                                                    <th class="tb-tnx-amount is-alt">
                                                                                        <span class="tb-tnx-total">Total</span>
                                                                                        <span class="tb-tnx-status d-none d-md-inline-block">Status</span>
                                                                                    </th>
                                                                                </tr><!-- tb-tnx-item -->
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($invoices as $key => $data)
                                                                                    <tr class="tb-tnx-item">
                                                                                        <td class="tb-tnx-id">
                                                                                            <a href="#"><span>{{$data->trx}}</span></a>
                                                                                        </td>
                                                                                        <td class="tb-tnx-info">
                                                                                            <div class="tb-tnx-desc">
                                                                                                <span class="title">{{$data->details}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-date">
                                                                                                <span class="date">{!! date(' d-m-Y', strtotime($data->created_at)) !!}</span>
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->amount, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="tb-tnx-amount is-alt">
                                                                                            <div class="tb-tnx-total">
                                                                                                <span class="amount">{{$basic->currency_sym}}{{number_format($data->total, $basic->decimal)}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-status">
                                                                                                @if($data->status == 1)
                                                                                                    <span class="badge badge-dot badge-success">Paid</span>
                                                                                                @elseif($data->status == 0)
                                                                                                    <span class="badge badge-dot badge-warning">Unpaid</span>
                                                                                                @elseif($data->status == 2)
                                                                                                    <span class="badge badge-dot badge-primary">Pending Confirmation</span>
                                                                                                @endif
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr><!-- tb-tnx-item -->
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- .card-inner -->
                                                                </div><!-- .card-inner-group -->
                                                            </div><!-- .card -->
                                                        </div><!-- .nk-block -->
                                                    </div>
                                                </div>
                                            </div><!-- .card-inner -->
                                        </div><!-- .card-content -->
                                        <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                                            <div class="card-inner-group" data-simplebar>
                                                <div class="card-inner">
                                                    <div class="user-card user-card-s2">
                                                        <div class="user-avatar lg bg-primary">
                                                            @if(file_exists($client->image))
                                                                <img src="{{url($client->image)}}" alt="">
                                                            @else
                                                                <img src="{{url('assets/images/profile.png')}}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="user-info">
                                                            <div class="badge badge-outline-light badge-pill ucap">Client</div>
                                                            <h5>{{$client->firstname.' '.$client->lastname}}</h5>
                                                            <span class="sub-text">{{$client->email}}</span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner card-inner-sm">
                                                    <div class="user-card user-card-s2">
                                                        <div class="user-info">
                                                            <div class="badge badge-outline-light badge-pill ucap">@if($client->level == 1) Reseller/Agent @elseif($client->level == 0) Client @endif Wallet</div>
                                                            <h5>Balance: {{$basic->currency_sym.number_format($client->balance, $basic->decimal)}}</h5>
                                                            <span class="sub-text">Earning: {{$basic->currency_sym.number_format($client->earning, $basic->decimal)}}</span>
                                                            <span class="sub-text">Cashback: {{$basic->currency_sym.number_format($client->cashback, $basic->decimal)}}</span>
                                                            <span class="sub-text">GB Points: {{$client->point}}Ps</span>
                                                            <span class="sub-text">MTN CG: {{$client->mtn_cg}}GB</span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner card-inner-sm">
                                                    <ul class="btn-toolbar justify-center gx-1">
                                                        <li><a href="{{ route('deactivate.client-tfa', $client->id) }}" class="btn btn-trigger btn-icon"><em class="icon ni ni-shield-off"></em></a></li>
                                                        <li><a href="#sendmail" data-toggle="modal" class="btn btn-trigger btn-icon"><em class="icon ni ni-mail"></em></a></li>
                                                        <li><a href="#credit" data-toggle="modal" class="btn btn-trigger btn-icon"><em class="icon ni ni-wallet"></em></a></li>
                                                        @if($client->level ==0)
                                                            <li><a href="{{ route('client.upgrade', $client->id) }}" class="btn btn-trigger btn-icon text-success"><em class="icon ni ni-arrow-up-right"></em></a></li>
                                                        @endif
                                                        @if($client->status ==0)
                                                            <li><a href="{{ route('activate.client', $client->id) }}" class="btn btn-trigger btn-icon text-success"><em class="icon ni ni-check-circle"></em></a></li>
                                                        @else
                                                            <li><a href="{{ route('deactivate.client', $client->id) }}" class="btn btn-trigger btn-icon text-danger"><em class="icon ni ni-na"></em></a></li>
                                                        @endif
                                                    </ul>
                                                </div><!-- .card-inner -->
                                                @php
                                                    $torder = \App\Models\Order::where(['user_id'=> $client->id])->count();
                                                    $corder = \App\Models\Order::where(['user_id'=> $client->id])->where('end','<', $timenow)->count();
                                                    $porder = \App\Models\Order::where(['user_id'=> $client->id , 'status' => 1])->count();
                                                @endphp
                                                <div class="card-inner">
                                                    <div class="row text-center">
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span class="amount">{{$torder}}</span>
                                                                <span class="sub-text">Total Order</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span class="amount">{{$corder}}</span>
                                                                <span class="sub-text">Complete</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span class="amount">{{$porder}}</span>
                                                                <span class="sub-text">Progress</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner">
                                                    <h6 class="overline-title-alt mb-2">Additional</h6>
                                                    <div class="row g-3">
                                                        <div class="col-6">
                                                            <span class="sub-text">User ID:</span>
                                                            <span>{{$client->id}}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sub-text">Last Login:</span>
                                                            <span>@if($lastlogin === NULL) N/A @else {{ Carbon\Carbon::parse($lastlogin->created_at)->diffForHumans() }} @endif</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sub-text">Client Status:</span>
                                                            @if($client->status ==1)
                                                                <span class="lead-text text-success">Active</span>
                                                            @else
                                                                <span class="lead-text text-warning">Inactive</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sub-text">Register At:</span>
                                                            <span>{{ Carbon\Carbon::parse($client->created_at)->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner">
                                                    <h6 class="overline-title-alt mb-3">Subscription</h6>
                                                    <ul class="g-1">
                                                        @if($client->sub_id > 0 && $client->sub_expiry > $timenow)
                                                            <li class="btn-group">
                                                                <a class="btn btn-xs btn-light btn-dim" href="#">Active</a>
                                                                <a class="btn btn-xs btn-icon btn-light btn-dim" href="#"><em class="icon ni ni-cross"></em></a>
                                                            </li>
                                                            <li class="btn-group">
                                                                <a class="btn btn-xs btn-light btn-dim" href="#">Expires {{ Carbon\Carbon::parse($client->sub_expiry)->diffForHumans() }}</a>
                                                                <a class="btn btn-xs btn-icon btn-light btn-dim" href="#"><em class="icon ni ni-cross"></em></a>
                                                            </li>
                                                        @else
                                                            <li class="btn-group">
                                                                <a class="btn btn-xs btn-light btn-dim" href="#">Inactive</a>
                                                                <a class="btn btn-xs btn-icon btn-light btn-dim" href="#"><em class="icon ni ni-cross"></em></a>
                                                            </li>
                                                            @if($client->sub_id > 0)
                                                                <li class="btn-group">
                                                                    <a class="btn btn-xs btn-light btn-dim" href="#">Expired {{ Carbon\Carbon::parse($client->sub_expiry)->diffForHumans() }}</a>
                                                                    <a class="btn btn-xs btn-icon btn-light btn-dim" href="#"><em class="icon ni ni-cross"></em></a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    </ul>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card-inner -->
                                        </div><!-- .card-aside -->
                                    </div><!-- .card-aside-wrap -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="sendmail">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Send Email</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('client.sendmail')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control" id="subject" name="id" value="{{$client->id}}" required>
                                <div class="form-group">
                                    <label class="form-label" for="subject">Email Subject</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="subject" name="subject" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="message">Message</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control form-control-sm summernote-basic" id="message" name="message"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Send Mail Now</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Send Client an Email</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="credit">
                <div class="modal-dialog modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Credit or Debit User</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('client.fund')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <div class="row g-gs">
                                    <input type="hidden" class="form-control" id="subject" name="id" value="{{$client->id}}" required>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="amount">Amount</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">{{$basic->currency_sym}}</span>
                                                </div>
                                                <input type="number" class="form-control" id="amount" name="amount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="reason">Reason</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                </div>
                                                <input type="text" class="form-control" id="reason" name="reason" placeholder="reason">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="wallet">Wallet</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-control form-select" id="wallet" name="wallet" data-placeholder="Select Wallet" required>
                                                    <option value="balance">Balance</option>
                                                    <option value="earning">Earning</option>
                                                    <option value="cashback">Cashback</option>
                                                    <option value="mtn_cg">MTN CG</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="status">Status</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-control form-select" id="status" name="status" data-placeholder="Select Service" required>
                                                    <option value="1">Credit</option>
                                                    <option value="0">Debit</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary">Fund Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Credit or Debit User</span>
                        </div>
                    </div>
                </div>
            </div>

<style>
.data-details {
    border-radius: 4px;
    padding: 18px 20px;
    border: 1px solid #d2dde9;
}
.data-details > div {
    flex-grow: 1;
    margin-bottom: 18px;
}
.data-details > div:last-child {
    margin-bottom: 0;
}
.data-details-title {
    font-size: 14px;
    font-weight: 600;
    color: #758698;
    line-height: 20px;
    display: block;
}
.data-details-info {
    font-size: 14px;
    font-weight: 400;
    color: #495463;
    line-height: 20px;
    display: block;
    margin-top: 6px;
}
.data-details-info.large {
    font-size: 20px;
}
.data-details-list {
    border-radius: 4px;
    border: 1px solid #d2dde9;
}
.data-details-list li {
    display: block;
}
.data-details-list li:last-child .data-details-des {
    border-bottom: none;
}
.data-details-head {
    font-size: 13px;
    font-weight: 500;
    color: #758698;
    line-height: 20px;
    padding: 15px 20px 2px;
    width: 100%;
}
.data-details-des {
    font-size: 14px;
    color: #495463;
    font-weight: 400;
    line-height: 20px;
    padding: 2px 20px 15px;
    flex-grow: 1;
    border-bottom: 1px solid #d2dde9;
    display: flex;
    justify-content: space-between;
}
.data-details-des .ti:not([data-toggle="tooltip"]),
.data-details-des [class*="fa"]:not([data-toggle="tooltip"]) {
    color: #1605ff;
}
.data-details-des span:last-child:not(:first-child) {
    font-size: 12px;
    color: #758698;
}
.data-details-des small {
    color: #758698;
}
.data-details-des span,
.data-details-des strong {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.data-details-docs {
    border-top: 1px solid #d2dde9;
    margin-top: 12px;
}
.data-details-docs-title {
    color: #495463;
    display: block;
    padding-bottom: 6px;
    font-weight: 400;
}
.data-details-docs > li {
    flex-grow: 1;
    border-bottom: 1px solid #d2dde9;
    padding: 20px;
}
.data-details-docs > li:last-child {
    border-bottom: none;
}
.data-details-alt {
    border-radius: 4px;
    border: 1px solid #d2dde9;
    font-weight: 400;
}
.data-details-alt li {
    line-height: 1.35;
    padding: 15px 20px;
    border-bottom: 1px solid #d2dde9;
}
.data-details-alt li:last-child {
    border-bottom: none;
}
.data-details-alt li div {
    padding: 3px 0;
}
.data-details-date {
    display: block;
    padding-bottom: 4px;
}
@media (min-width: 576px) {
    .data-details-list > li {
        display: flex;
        align-items: center;
    }
    .data-details-head {
        width: 190px;
        padding: 14px 20px;
    }
    .data-details-des {
        border-top: none;
        border-left: 1px solid #d2dde9;
        width: calc(100% - 190px);
        padding: 14px 20px;
    }
}
</style>

                <!-- Bills History Modal Starts Here-->
                @foreach ($bills as $key => $data)
                    <div class="modal fade" id="tranxDetails-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="tranxDetails-{{$data->id}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tranxDetails-{{$data->id}}">Transaction Id: {{$data->trx}}</h5>
                                </div>
                                <div class="modal-body">
                                    <ul class="data-details-list">
                                        <li><div class="data-details-head">Service</div><div class="data-details-des">{{$data->service_type}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Provider</div><div class="data-details-des">{{$data->provider}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Recipient</div><div class="data-details-des">{{$data->recipient}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Amount</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->amount, $gnl->decimal)}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Fee</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->fee, $gnl->decimal)}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Discount</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->discount, $gnl->decimal)}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Voucher</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->voucher, $gnl->decimal)}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Paid</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->paid, $gnl->decimal)}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Initial Balance</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->init_bal, $gnl->decimal)}}</div></li><!-- li -->
                                        <li><div class="data-details-head">New Balance</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->new_bal, $gnl->decimal)}}</div></li><!-- li -->
                                        @if($data->user->level > 0)
                                            <li><div class="data-details-head">CG Charged</div><div class="data-details-des">{{$data->cg}}</div></li><!-- li -->
                                            <li><div class="data-details-head">Initial CG</div><div class="data-details-des">{{$data->init_cg}}</div></li><!-- li -->
                                            <li><div class="data-details-head">New CG</div><div class="data-details-des">{{$data->new_cg}}</div></li><!-- li -->
                                        @endif
                                        <li><div class="data-details-head">Source Debit</div><div class="data-details-des">{{$data->debit}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Channel</div><div class="data-details-des">{{$data->channel}}</div></li><!-- li -->
                                        <li><div class="data-details-head">orderNo</div><div class="data-details-des">{{$data->ref}}</div></li><!-- li -->
                                        @if($data->channel == "API")
                                            <li><div class="data-details-head">Reference</div><div class="data-details-des">{{$data->api_req_id}}</div></li><!-- li -->
                                        @endif
                                        @if($data->service_type == "electricity")
                                            <li><div class="data-details-head">Purchased Code</div><div class="data-details-des">{{$data->purchased_code}}</div></li><!-- li -->
                                            <li><div class="data-details-head">Units</div><div class="data-details-des">{{$data->units}}</div></li><!-- li -->
                                        @endif
                                        <li><div class="data-details-head">Status</div><div class="data-details-des">{{$data->status}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Response</div><div class="data-details-des">{{$data->errorMsg}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Date</div><div class="data-details-des">{!! date('d M, Y H:i A', strtotime($data->created_at)) !!}</div></li><!-- li -->
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Bills History Modal Ends Here -->
@endsection
