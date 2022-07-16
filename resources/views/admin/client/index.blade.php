@extends('layouts.admindashboard')
@section('title', 'Clients')

@section('content')

            @php
                $all = \App\Models\User::count();
            @endphp
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Client List</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>You have total <b>{{$all}}</b> clients.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    {{-- <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li> --}}
                                                    {{-- <li class="nk-block-tools-opt">
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><span>Add User</span></a></li>
                                                                    <li><a href="#"><span>Add Team</span></a></li>
                                                                    <li><a href="#"><span>Import User</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered card-stretch">
                                    <div class="card-inner-group">
                                        <div class="card-inner p-0">
                                            <div class="nk-tb-list nk-tb-ulist">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input" id="uid">
                                                            <label class="custom-control-label" for="uid"></label>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col"><span class="sub-text">Client Name</span></div>
                                                    <div class="nk-tb-col tb-col-mb"><span class="sub-text">Balance</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Phone</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span class="sub-text">Location</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span class="sub-text">Last Login</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                                                    <div class="nk-tb-col nk-tb-col-tools text-right"></div>
                                                </div><!-- .nk-tb-item -->
                                                @foreach($clients as $key => $data)
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input" id="uid1">
                                                                <label class="custom-control-label" for="uid1"></label>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <a href="{{ route('client.details', $data->id) }}">
                                                                <div class="user-card">
                                                                    <div class="user-avatar bg-primary">
                                                                        @if(file_exists($data->image))
                                                                            <img src="{{url($data->image)}}" alt="">
                                                                        @else
                                                                            <img src="{{url('assets/images/profile.png')}}" alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="user-info">
                                                                        <span class="tb-lead">{{$data->firstname.' '.$data->lastname}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                                        <span>{{$data->email}}</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        @php
                                                            $lastlog = \App\Models\UserLogin::where(['user_id'=> $data->id])->latest()->first();
                                                            $cll = \App\Models\UserLogin::where(['user_id'=> $data->id])->get();
                                                        @endphp
                                                        <div class="nk-tb-col tb-col-mb">
                                                            <span class="tb-amount">{{$basic->currency_sym}}{{number_format($data->balance, $basic->decimal)}}</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span>{{$data->phone}}</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <ul class="list-status">
                                                                <li><em class="icon ni ni-map-pin"></em> <span>{{$data->city}}</span></li>
                                                                <li><em class="icon ni ni-map"></em> <span>{{$data->state}}</span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            @if(count($cll) > 0)
                                                                <span>{{ Carbon\Carbon::parse($lastlog->created_at)->diffForHumans() }}</span>
                                                            @else
                                                                <span>N/A</span>
                                                            @endif
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            @if($data->status ==1)
                                                                <span class="tb-status text-success">Active</span>
                                                            @else
                                                                <span class="tb-status text-warning">Inactive</span>
                                                            @endif
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <li>
                                                                    <div class="drodown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                {{-- <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li> --}}
                                                                                <li><a href="{{ route('client.details', $data->id) }}"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                                {{-- <li><a href="#"><em class="icon ni ni-repeat"></em><span>Transaction</span></a></li>
                                                                                <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li> --}}
                                                                                <li class="divider"></li>
                                                                                @if($data->tfa ==1)
                                                                                    <li><a href="{{ route('deactivate.client-tfa', $data->id) }}"><em class="icon ni ni-shield-off"></em><span>Reset/Disable 2FA</span></a></li>
                                                                                @endif
                                                                                @if($data->status ==0)
                                                                                    <li><a href="{{ route('activate.client', $data->id) }}"><em class="icon ni ni-check-circle"></em><span>Activate Client</span></a></li>
                                                                                @else
                                                                                    <li><a href="{{ route('deactivate.client', $data->id) }}"><em class="icon ni ni-na"></em><span>Suspend Client</span></a></li>
                                                                                @endif
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
                                        @include('pagination.admin', ['paginator' => $clients])
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
@endsection
