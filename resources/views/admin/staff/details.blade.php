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
                                        <h3 class="nk-block-title page-title">Staff / <strong class="text-primary small">{{$staff->name}}</strong></h3>
                                        <div class="nk-block-des text-soft">
                                            <ul class="list-inline">
                                                <li>Staff ID: <span class="text-base">{{$staff->id}}</span></li>
                                                <li>Last Login: <span class="text-base">@if($lastlogin === NULL)N/A @else {!! date(' d M, Y h:i A', strtotime($lastlogin->created_at)) !!} @endif</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="{{ route('staffs') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                        <a href="{{ route('staffs') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
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
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem2"><em class="icon ni ni-repeat"></em><span>Lead</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem3"><em class="icon ni ni-wallet-saving"></em><span>Support</span></a>
                                                </li>
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem4"><em class="icon ni ni-file-text"></em><span>Documents</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tabItem5"><em class="icon ni ni-activity"></em><span>Activities</span></a>
                                                </li> --}}
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
                                                                <p>Staff Basic Information.</p>
                                                            </div><!-- .nk-block-head -->
                                                            <div class="profile-ud-list">
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Fullname</span>
                                                                        <span class="profile-ud-value">{{$staff->name}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Username</span>
                                                                        <span class="profile-ud-value">{{$staff->username}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Email</span>
                                                                        <span class="profile-ud-value">{{$staff->email}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Phone Number</span>
                                                                        <span class="profile-ud-value">{{$staff->phone}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Role</span>
                                                                        <span class="profile-ud-value">{{$staff->role}}</span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- .profile-ud-list -->
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
                                                                                <h5 class="title">Team Lead</h5>
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
                                                                                            <span>Order</span>
                                                                                        </span>
                                                                                        <span class="tb-tnx-date d-md-inline-block d-none">
                                                                                            <span class="d-md-none">Date</span>
                                                                                            <span class="d-none d-md-block">
                                                                                                <span>Order Date</span>
                                                                                                <span>Due Date</span>
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
                                                                                @foreach($orders as $key => $data)
                                                                                    <tr class="tb-tnx-item">
                                                                                        <td class="tb-tnx-id">
                                                                                            <a href="#"><span>{{$data->id}}</span></a>
                                                                                        </td>
                                                                                        <td class="tb-tnx-info">
                                                                                            <div class="tb-tnx-desc">
                                                                                                <span class="title">{{$data->service->name}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-date">
                                                                                                <span class="date">{!! date(' d-m-Y', strtotime($data->created_at)) !!}</span>
                                                                                                <span class="date">{!! date(' d-m-Y', strtotime($data->end)) !!}</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="tb-tnx-amount is-alt">
                                                                                            <div class="tb-tnx-total">
                                                                                                <span class="amount">@if($data->price ==0)FREE @else {{$basic->currency_sym}}{{number_format($data->price, $basic->decimal)}} @endif</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-status">
                                                                                                @if($data->end < $timenow && $data->status == 1)
                                                                                                    <span class="badge badge-dot badge-success">Completed</span>
                                                                                                @elseif($data->status == 1)
                                                                                                    <span class="badge badge-dot badge-primary">Active</span>
                                                                                                @elseif($data->status == 0)
                                                                                                    <span class="badge badge-dot badge-warning">Pending</span>
                                                                                                @elseif($data->status == 2)
                                                                                                    <span class="badge badge-dot badge-danger">Cancelled</span>
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
                                                                                <h5 class="title">Team Support</h5>
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
                                                                                            <span>Order</span>
                                                                                        </span>
                                                                                        <span class="tb-tnx-date d-md-inline-block d-none">
                                                                                            <span class="d-md-none">Date</span>
                                                                                            <span class="d-none d-md-block">
                                                                                                <span>Order Date</span>
                                                                                                <span>Due Date</span>
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
                                                                                @foreach($sorders as $key => $data)
                                                                                    <tr class="tb-tnx-item">
                                                                                        <td class="tb-tnx-id">
                                                                                            <a href="#"><span>{{$data->id}}</span></a>
                                                                                        </td>
                                                                                        <td class="tb-tnx-info">
                                                                                            <div class="tb-tnx-desc">
                                                                                                <span class="title">{{$data->service->name}}</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-date">
                                                                                                <span class="date">{!! date(' d-m-Y', strtotime($data->created_at)) !!}</span>
                                                                                                <span class="date">{!! date(' d-m-Y', strtotime($data->end)) !!}</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="tb-tnx-amount is-alt">
                                                                                            <div class="tb-tnx-total">
                                                                                                <span class="amount">@if($data->price ==0)FREE @else {{$basic->currency_sym}}{{number_format($data->price, $basic->decimal)}} @endif</span>
                                                                                            </div>
                                                                                            <div class="tb-tnx-status">
                                                                                                @if($data->end < $timenow && $data->status == 1)
                                                                                                    <span class="badge badge-dot badge-success">Completed</span>
                                                                                                @elseif($data->status == 1)
                                                                                                    <span class="badge badge-dot badge-primary">Active</span>
                                                                                                @elseif($data->status == 0)
                                                                                                    <span class="badge badge-dot badge-warning">Pending</span>
                                                                                                @elseif($data->status == 2)
                                                                                                    <span class="badge badge-dot badge-danger">Cancelled</span>
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
                                                    {{-- <div class="tab-pane" id="tabItem4">
                                                        <div class="nk-block">
                                                            <div class="nk-block-head">
                                                                <h5 class="title">Personal Information</h5>
                                                                <p>Basic info, like your name and address, that you use on Nio Platform.</p>
                                                            </div><!-- .nk-block-head -->
                                                            <div class="profile-ud-list">
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Title</span>
                                                                        <span class="profile-ud-value">Mr.</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Full Name</span>
                                                                        <span class="profile-ud-value">Abu Bin Ishtiyak</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Date of Birth</span>
                                                                        <span class="profile-ud-value">10 Aug, 1980</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Surname</span>
                                                                        <span class="profile-ud-value">IO</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Mobile Number</span>
                                                                        <span class="profile-ud-value">01713040400</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Email Address</span>
                                                                        <span class="profile-ud-value">info@softnio.com</span>
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
                                                                        <span class="profile-ud-label">Joining Date</span>
                                                                        <span class="profile-ud-value">08-16-2018 09:04PM</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Reg Method</span>
                                                                        <span class="profile-ud-value">Email</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Country</span>
                                                                        <span class="profile-ud-value">United State</span>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Nationality</span>
                                                                        <span class="profile-ud-value">United State</span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- .profile-ud-list -->
                                                        </div><!-- .nk-block -->
                                                        <div class="nk-divider divider md"></div>
                                                        <div class="nk-block">
                                                            <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                                <h5 class="title">Admin Note</h5>
                                                                <a href="#" class="link link-sm">+ Add Note</a>
                                                            </div><!-- .nk-block-head -->
                                                            <div class="bq-note">
                                                                <div class="bq-note-item">
                                                                    <div class="bq-note-text">
                                                                        <p>Aproin at metus et dolor tincidunt feugiat eu id quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean sollicitudin non nunc vel pharetra. </p>
                                                                    </div>
                                                                    <div class="bq-note-meta">
                                                                        <span class="bq-note-added">Added on <span class="date">November 18, 2019</span> at <span class="time">5:34 PM</span></span>
                                                                        <span class="bq-note-sep sep">|</span>
                                                                        <span class="bq-note-by">By <span>Softnio</span></span>
                                                                        <a href="#" class="link link-sm link-danger">Delete Note</a>
                                                                    </div>
                                                                </div><!-- .bq-note-item -->
                                                                <div class="bq-note-item">
                                                                    <div class="bq-note-text">
                                                                        <p>Aproin at metus et dolor tincidunt feugiat eu id quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean sollicitudin non nunc vel pharetra. </p>
                                                                    </div>
                                                                    <div class="bq-note-meta">
                                                                        <span class="bq-note-added">Added on <span class="date">November 18, 2019</span> at <span class="time">5:34 PM</span></span>
                                                                        <span class="bq-note-sep sep">|</span>
                                                                        <span class="bq-note-by">By <span>Softnio</span></span>
                                                                        <a href="#" class="link link-sm link-danger">Delete Note</a>
                                                                    </div>
                                                                </div><!-- .bq-note-item -->
                                                            </div><!-- .bq-note -->
                                                        </div><!-- .nk-block -->
                                                    </div> --}}
                                                </div>
                                            </div><!-- .card-inner -->
                                        </div><!-- .card-content -->
                                        <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                                            <div class="card-inner-group" data-simplebar>
                                                <div class="card-inner">
                                                    <div class="user-card user-card-s2">
                                                        <div class="user-avatar lg bg-primary">
                                                            @if(file_exists($staff->image))
                                                                <img src="{{url($staff->image)}}" alt="">
                                                            @else
                                                                <img src="{{url('assets/images/profile.png')}}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="user-info">
                                                            <div class="badge badge-outline-light badge-pill ucap">Staff</div>
                                                            <h5>{{$staff->name}}</h5>
                                                            <span class="sub-text">{{$staff->email}}</span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner card-inner-sm">
                                                    <ul class="btn-toolbar justify-center gx-1">
                                                        <li><a href="#sendmail" data-toggle="modal" class="btn btn-trigger btn-icon"><em class="icon ni ni-mail"></em></a></li>
                                                        {{-- <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-download-cloud"></em></a></li>
                                                        <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-bookmark"></em></a></li> --}}
                                                        @if($staff->status ==0)
                                                        <li><a href="{{ route('activate.staff', $staff->id) }}" class="btn btn-trigger btn-icon text-success"><em class="icon ni ni-check-circle"></em></a></li>
                                                        @else
                                                        <li><a href="{{ route('deactivate.staff', $staff->id) }}" class="btn btn-trigger btn-icon text-danger"><em class="icon ni ni-na"></em></a></li>
                                                        @endif
                                                    </ul>
                                                </div><!-- .card-inner -->
                                                @php
                                                    $torder = \App\Models\Order::where('staff_id',$staff->id)->orwhere('sstaff_id',$staff->id)->count();
                                                    $corder = \App\Models\Order::where('staff_id',$staff->id)->count();
                                                    $porder = \App\Models\Order::where('sstaff_id',$staff->id)->count();
                                                @endphp
                                                <div class="card-inner">
                                                    <div class="row text-center">
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span class="amount">{{$torder}}</span>
                                                                <span class="sub-text">Order Assigned</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span class="amount">{{$corder}}</span>
                                                                <span class="sub-text">Order Lead</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span class="amount">{{$porder}}</span>
                                                                <span class="sub-text">Order Support</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner">
                                                    <h6 class="overline-title-alt mb-2">Additional</h6>
                                                    <div class="row g-3">
                                                        <div class="col-6">
                                                            <span class="sub-text">Staff ID:</span>
                                                            <span>{{$staff->id}}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sub-text">Last Login:</span>
                                                            <span>@if($lastlogin === NULL) N/A @else {{ Carbon\Carbon::parse($lastlogin->created_at)->diffForHumans() }} @endif</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sub-text">Staff Status:</span>
                                                            @if($staff->status ==1)
                                                                <span class="lead-text text-success">Active</span>
                                                            @else
                                                                <span class="lead-text text-warning">Suspended</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sub-text">Staff Since:</span>
                                                            <span>{{ Carbon\Carbon::parse($staff->created_at)->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
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
                                <input type="hidden" class="form-control" id="subject" name="id" value="{{$staff->id}}" required>
                                <div class="form-group">
                                    <label class="form-label" for="subject">Email Subject</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="subject" name="subject" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="message">Message</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control form-control-sm" id="message" name="message" placeholder="Write your message" required></textarea>
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
@endsection