@extends('layouts.admindashboard')
@section('title', 'Subscribers')

@section('content')

            @php
                $all = \App\Models\Subscriber::count();
            @endphp
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Subscriber List</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>You have total <b>{{$all}}</b> subscribers.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li><a href="{{ route('send.mail.subscriber') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-mail-fill"></em><span>Send Email</span></a></li>
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
                                                    <div class="nk-tb-col"><span class="sub-text">Subscriber Name</span></div>
                                                    <div class="nk-tb-col tb-col-mb"><span class="sub-text">Email</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span class="sub-text">Subscribed Date</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                                                    <div class="nk-tb-col nk-tb-col-tools text-right"></div>
                                                </div><!-- .nk-tb-item -->
                                                @foreach($events as $key => $data)
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input" id="uid1">
                                                                <label class="custom-control-label" for="uid1"></label>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <div class="user-card">
                                                                <div class="user-avatar bg-primary">
                                                                    <img src="{{url('assets/images/profile.png')}}" alt="">
                                                                </div>
                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{$data->name}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                                    <span>{{$data->email}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-mb">
                                                            <span class="tb-amount">{{$data->email}}</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span>{{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            @if($data->status ==1)
                                                                <span class="tb-status text-success">Subscribed</span>
                                                            @else
                                                                <span class="tb-status text-warning">Unsuscribed</span>
                                                            @endif
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <li>
                                                                    <div class="drodown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                @if($data->status ==0)
                                                                                    <li><a href="{{ route('update.subscriber', $data->id) }}"><em class="icon ni ni-check-circle"></em><span>Subscribe</span></a></li>
                                                                                @else
                                                                                    <li><a href="{{ route('update.subscriber', $data->id) }}"><em class="icon ni ni-na"></em><span>Unsubscribe</span></a></li>
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
                                        @include('pagination.default', ['paginator' => $events])
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
@endsection
