@extends('layouts.admindashboard')
@section('title', $page_title)

@section('content')
@include('layouts.css')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Bill History</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>You have a total of <b>{{$count_bills}}</b> bill(s). - {{$count_gb}}GB</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li><a href="#" class="btn btn-white btn-dim btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                                    <li class="nk-block-tools-opt">
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><span>Add Tranx</span></a></li>
                                                                    <li><a href="#"><span>Add Deposit</span></a></li>
                                                                    <li><a href="#"><span>Add Withdraw</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered card-stretch">
                                    <div class="card-inner-group">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h5 class="title">All Bills</h5>
                                                </div>
                                                <div class="card-tools mr-n1">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li>
                                                            <a href="#" class="search-toggle toggle-search btn btn-icon" data-target="search"><em class="icon ni ni-search"></em></a>
                                                        </li><!-- li -->
                                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                    <div class="badge badge-circle badge-primary">4</div>
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>
                                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                                    <div class="dropdown-head">
                                                                        <span class="sub-title dropdown-title">Advance Filter</span>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="link link-light">
                                                                                <em class="icon ni ni-more-h"></em>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-body dropdown-body-rg">
                                                                        <div class="row gx-6 gy-4">
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Type</label>
                                                                                    <select class="form-select form-select-sm">
                                                                                        <option value="any">Any Type</option>
                                                                                        <option value="airtime">Airtime</option>
                                                                                        <option value="internet">Internet Data</option>
                                                                                        <option value="tv">Cable Tv</option>
                                                                                        <option value="electricity">Electricity</option>
                                                                                        <option value="betting">Betting</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                                    <select class="form-select form-select-sm">
                                                                                        <option value="any">Any Status</option>
                                                                                        <option value="pending">Pending</option>
                                                                                        <option value="failed">Failed</option>
                                                                                        <option value="process">Process</option>
                                                                                        <option value="completed">Completed</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Pay Currency</label>
                                                                                    <select class="form-select form-select-sm">
                                                                                        <option value="any">Any Coin</option>
                                                                                        <option value="bitcoin">Bitcoin</option>
                                                                                        <option value="ethereum">Ethereum</option>
                                                                                        <option value="litecoin">Litecoin</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Channel</label>
                                                                                    <select class="form-select form-select-sm">
                                                                                        <option value="any">Any Channel</option>
                                                                                        <option value="website">Website</option>
                                                                                        <option value="api">API</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" id="includeDel">
                                                                                        <label class="custom-control-label" for="includeDel"> Including Deleted</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-secondary">Filter</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-foot between">
                                                                        <a class="clickable" href="#">Reset Filter</a>
                                                                        <a href="#savedFilter" data-toggle="modal">Save Filter</a>
                                                                    </div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                    <em class="icon ni ni-setting"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                    <ul class="link-check">
                                                                        <li><span>Show</span></li>
                                                                        <li class="active"><a href="#">10</a></li>
                                                                        <li><a href="#">20</a></li>
                                                                        <li><a href="#">50</a></li>
                                                                    </ul>
                                                                    <ul class="link-check">
                                                                        <li><span>Order</span></li>
                                                                        <li class="active"><a href="#">DESC</a></li>
                                                                        <li><a href="#">ASC</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                    </ul><!-- .btn-toolbar -->
                                                </div><!-- .card-tools -->
                                                <div class="card-search search-wrap" data-search="search">
                                                    <div class="search-content">
                                                        <form action="{{route('bills.search')}}" method="post">
                                                            @csrf
                                                            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                                            <input type="text" class="form-control border-transparent form-focus-none" name="search" placeholder="Quick search by transaction ID, api Reference, orderNo or Recipient">
                                                            <button type="submit" class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                                        </form>
                                                    </div>
                                                </div><!-- .card-search -->
                                            </div><!-- .card-title-group -->
                                        </div><!-- .card-inner -->
                                        <div class="card-inner p-0">
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
                                                                @elseif($data->status =="PENDING" || $data->status =="initiated")
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
                                                            <span class="badge badge-dot badge-success">{{$data->service_type}} - {{$data->channel}}</span>
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
                                                        @elseif($data->status =="PENDING" || $data->status =="initiated")
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
                                        @include('pagination.admin', ['paginator' => $bills])
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

                <!-- Modal -->
                @foreach ($bills as $key => $data)
                    <div class="modal fade" id="tranxDetails-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="tranxDetails-{{$data->id}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tranxDetails-{{$data->id}}">Transaction Id: {{$data->trx}}</h5>
                                </div>
                                <div class="modal-body">
                                    <ul class="data-details-list">
                                        <li><div class="data-details-head">Client Name</div><div class="data-details-des">{{$data->user->firstname}} {{$data->user->lastname}}</div></li><!-- li -->
                                        <li><div class="data-details-head">Client Username</div><div class="data-details-des"><a href="{{ route('client.details', $data->user->id) }}">{{$data->user->username}}</a></div></li><!-- li -->
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
                                            <li><div class="data-details-head">CG Charged</div><div class="data-details-des">{{$data->cg}}GB</div></li><!-- li -->
                                            <li><div class="data-details-head">Initial CG</div><div class="data-details-des">{{$data->init_cg}}GB</div></li><!-- li -->
                                            <li><div class="data-details-head">New CG</div><div class="data-details-des">{{$data->new_cg}}GB</div></li><!-- li -->
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

@endsection
