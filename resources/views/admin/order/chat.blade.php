@extends('layouts.admindashboard')
@section('title', 'Chat')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-chat">
                                <div class="nk-chat-aside">
                                    <div class="nk-chat-aside-head">
                                        <div class="nk-chat-aside-user">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <div class="user-avatar">
                                                        <img src="{{ asset('assets/images/favicon.png') }}" alt="">
                                                    </div>
                                                    <div class="title">Chats</div>
                                                </a>
                                            </div>
                                        </div><!-- .nk-chat-aside-user -->
                                        <ul class="nk-chat-aside-tools g-2">
                                            <li>
                                                <div class="dropdown">
                                                    <a href="javascript:window.location.href=window.location.href" class="btn btn-round btn-icon btn-light">
                                                        <em class="icon ni ni-reload"></em>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="{{ route('service.details',$order->id) }}" class="btn btn-round btn-icon btn-light">
                                                    <em class="icon ni ni-curve-up-left"></em>
                                                </a>
                                            </li>
                                        </ul><!-- .nk-chat-aside-tools -->
                                    </div><!-- .nk-chat-aside-head -->
                                    <div class="nk-chat-aside-body" data-simplebar>
                                        <div class="nk-chat-aside-search">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-left">
                                                        <em class="icon ni ni-search"></em>
                                                    </div>
                                                    <input type="text" class="form-control form-round" id="default-03" placeholder="Search by name">
                                                </div>
                                            </div>
                                        </div><!-- .nk-chat-aside-search -->
                                        <div class="nk-chat-aside-panel nk-chat-fav">
                                            <h6 class="title overline-title-alt">Team</h6>
                                            <ul class="fav-list">
                                                @if ($order->staff_id != 0)
                                                    <li>
                                                        @if(file_exists($order->staff->image))
                                                            <div class="user-avatar" data-toggle="tooltip" title="{{$order->staff->name}}">
                                                                <img src="{{url($order->staff->image)}}" alt="{{$order->staff->name}}">
                                                                @if($order->staff->online == NULL)
                                                                    <span class="status dot dot-lg dot-danger"></span>
                                                                @elseif ($timenow->diffInMinutes($order->staff->online) < 5)
                                                                    <span class="status dot dot-lg dot-success"></span>
                                                                @elseif($timenow->diffInMinutes($order->staff->online) > 5 && $timenow->diffInMinutes($order->staff->online) < 10)
                                                                    <span class="status dot dot-lg dot-warning"></span>
                                                                @elseif($timenow->diffInMinutes($order->staff->online) > 10)
                                                                    <span class="status dot dot-lg dot-danger"></span>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="user-avatar" data-toggle="tooltip" title="{{$order->staff->name}}">
                                                                <img src="{{url('assets/images/profile.png')}}" alt="{{$order->staff->name}}">
                                                                @if($order->staff->online == NULL)
                                                                    <span class="status dot dot-lg dot-danger"></span>
                                                                @elseif ($timenow->diffInMinutes($order->staff->online) < 5)
                                                                    <span class="status dot dot-lg dot-success"></span>
                                                                @elseif($timenow->diffInMinutes($order->staff->online) > 5 && $timenow->diffInMinutes($order->staff->online) < 10)
                                                                    <span class="status dot dot-lg dot-warning"></span>
                                                                @elseif($timenow->diffInMinutes($order->staff->online) > 10)
                                                                    <span class="status dot dot-lg dot-danger"></span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </li>
                                                @else
                                                    <li>
                                                        <div class="user-avatar" data-toggle="tooltip" title="Not Assigned Yet">
                                                            <img src="" alt="">
                                                        </div>
                                                    </li>
                                                @endif
                                                @if ($order->sstaff_id != 0)
                                                    <li>
                                                        @if(file_exists($order->sstaff->image))
                                                            <div class="user-avatar" data-toggle="tooltip" title="{{$order->sstaff->name}}">
                                                                <img src="{{url($order->sstaff->image)}}" alt="{{$order->sstaff->name}}">
                                                                @if($order->sstaff->online == NULL)
                                                                    <span class="status dot dot-lg dot-danger"></span>
                                                                @elseif ($timenow->diffInMinutes($order->sstaff->online) < 5)
                                                                    <span class="status dot dot-lg dot-success"></span>
                                                                @elseif($timenow->diffInMinutes($order->sstaff->online) > 5 && $timenow->diffInMinutes($order->sstaff->online) < 10)
                                                                    <span class="status dot dot-lg dot-warning"></span>
                                                                @elseif($timenow->diffInMinutes($order->sstaff->online) > 10)
                                                                    <span class="status dot dot-lg dot-danger"></span>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="user-avatar" data-toggle="tooltip" title="{{$order->sstaff->name}}">
                                                                <img src="{{url('assets/images/profile.png')}}" alt="{{$order->sstaff->name}}">
                                                                @if($order->sstaff->online == NULL)
                                                                    <span class="status dot dot-lg dot-danger"></span>
                                                                @elseif ($timenow->diffInMinutes($order->sstaff->online) < 5)
                                                                    <span class="status dot dot-lg dot-success"></span>
                                                                @elseif($timenow->diffInMinutes($order->sstaff->online) > 5 && $timenow->diffInMinutes($order->sstaff->online) < 10)
                                                                    <span class="status dot dot-lg dot-warning"></span>
                                                                @elseif($timenow->diffInMinutes($order->sstaff->online) > 10)
                                                                    <span class="status dot dot-lg dot-danger"></span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </li>
                                                @else
                                                    <li>
                                                        <div class="user-avatar" data-toggle="tooltip" title="Not Assigned Yet">
                                                            <img src="" alt="">
                                                        </div>
                                                    </li>
                                                @endif
                                            </ul><!-- .fav-list -->
                                        </div><!-- .nk-chat-fav -->
                                        <div class="nk-chat-list">
                                            <h6 class="title overline-title-alt">Messages</h6>
                                            <ul class="chat-list">
                                                <li class="chat-item">
                                                    <a class="chat-link chat-open" href="#">
                                                        <div class="chat-media user-avatar bg-purple">
                                                            @if(file_exists($order->user->image))
                                                                <div class="user-avatar" data-toggle="tooltip" title="{{$order->user->firstname}}">
                                                                    <img src="{{url($order->user->image)}}" alt="{{$order->user->firstname}}">
                                                                    @if($order->user->online == NULL)
                                                                        <span class="status dot dot-lg dot-danger"></span>
                                                                    @elseif ($timenow->diffInMinutes($order->user->online) < 5)
                                                                        <span class="status dot dot-lg dot-success"></span>
                                                                    @elseif($timenow->diffInMinutes($order->user->online) > 5 && $timenow->diffInMinutes($order->user->online) < 10)
                                                                        <span class="status dot dot-lg dot-warning"></span>
                                                                    @elseif($timenow->diffInMinutes($order->user->online) > 10)
                                                                        <span class="status dot dot-lg dot-danger"></span>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="user-avatar" data-toggle="tooltip" title="{{$order->user->firstname}}">
                                                                    <img src="{{url('assets/images/profile.png')}}" alt="{{$order->user->firstname}}">
                                                                    @if($order->user->online == NULL)
                                                                        <span class="status dot dot-lg dot-danger"></span>
                                                                    @elseif ($timenow->diffInMinutes($order->user->online) < 5)
                                                                        <span class="status dot dot-lg dot-success"></span>
                                                                    @elseif($timenow->diffInMinutes($order->user->online) > 5 && $timenow->diffInMinutes($order->user->online) < 10)
                                                                        <span class="status dot dot-lg dot-warning"></span>
                                                                    @elseif($timenow->diffInMinutes($order->user->online) > 10)
                                                                        <span class="status dot dot-lg dot-danger"></span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="chat-info">
                                                            <div class="chat-from">
                                                                <div class="name">{{$order->service->name}}</div>
                                                                <span class="time">@if($last === NULL)N/A @else {{ Carbon\Carbon::parse($last->created_at)->diffForHumans() }} @endif</span>
                                                            </div>
                                                            <div class="chat-context">
                                                                <div class="text">
                                                                    <p>@if($last === NULL)  @else {{$last->comment}} @endif</p>
                                                                </div>
                                                                <div class="status delivered">
                                                                    <em class="icon ni ni-check-circle-fill"></em>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li><!-- .chat-item -->
                                            </ul><!-- .chat-list -->
                                        </div><!-- .nk-chat-list -->
                                        <div class="nk-chat-list">
                                            <p>Service Name: {{$order->service->name}}</p>
                                            <p>Service Category: {{$order->cat->name}}</p>
                                            <p>Order Invoice: {{$order->invoice_trx}}</p>
                                            <p>Order ID: #{{$order->id}}</p>
                                        </div><!-- .nk-chat-list -->
                                    </div>
                                </div><!-- .nk-chat-aside -->
                                <div class="nk-chat-body profile-shown">
                                    <div class="nk-chat-head">
                                        <ul class="nk-chat-head-info">
                                            <li class="nk-chat-body-close">
                                                <a href="javascript:window.location.href=window.location.href" class="btn btn-icon btn-trigger nk-chat-hide ml-n1"><em class="icon ni ni-arrow-left"></em></a>
                                            </li>
                                            <li class="nk-chat-head-user">
                                                <div class="user-card">
                                                    <div class="user-avatar bg-purple">
                                                        <img src="{{ asset('assets/images/favicon.png') }}" alt="">
                                                    </div>
                                                    <div class="user-info">
                                                        <div class="lead-text">{{$order->service->name}}</div>
                                                        <div class="sub-text"><span class="d-none d-sm-inline mr-1">Client Last Reply </span> @if($last === NULL)N/A @else {!! date(' d M, Y h:i A', strtotime($last->created_at)) !!} @endif</div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="nk-chat-head-tools">
                                            {{-- <li><a href="#" class="btn btn-icon btn-trigger text-primary"><em class="icon ni ni-call-fill"></em></a></li>
                                            <li><a href="#" class="btn btn-icon btn-trigger text-primary"><em class="icon ni ni-video-fill"></em></a></li> --}}
                                            <li><a href="javascript:window.location.href=window.location.href" class="btn btn-icon btn-trigger text-primary"><em class="icon ni ni-reload-alt"></em></a></li>
                                        </ul>
                                    </div><!-- .nk-chat-head -->
                                    <div class="nk-chat-panel" data-simplebar>
                                        @foreach ($replies as $data)
                                            @if ($data->type == 1)
                                                <div class="chat is-you">
                                                    <div class="chat-avatar">
                                                        <div class="user-avatar bg-purple">
                                                            @if (file_exists($data->user->image))
                                                                <img src="{{url($data->user->image)}}" alt="">
                                                            @else
                                                                <img src="{{url('assets/images/profile.png')}}" alt="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="chat-content">
                                                        <div class="chat-bubbles">
                                                            <div class="chat-bubble">
                                                                <div class="chat-msg"> {{$data->comment}} </div>
                                                                {{-- <ul class="chat-msg-more">
                                                                    <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                    <li>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul> --}}
                                                            </div>
                                                        </div>
                                                        <ul class="chat-meta">
                                                            <li>{{$data->user->firstname.' '.$data->user->lastname}}</li>
                                                            <li>{{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</li>
                                                        </ul>
                                                    </div>
                                                </div><!-- .chat -->
                                            @else
                                                <div class="chat is-me">
                                                    <div class="chat-content">
                                                        <div class="chat-bubbles">
                                                            <div class="chat-bubble">
                                                                <div class="chat-msg"> {{$data->comment}} </div>
                                                                {{-- <ul class="chat-msg-more">
                                                                    <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                    <li>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-sm">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul> --}}
                                                            </div>
                                                        </div>
                                                        <ul class="chat-meta">
                                                            <li>{{$data->staff->name}}</li>
                                                            <li>{{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</li>
                                                        </ul>
                                                    </div>
                                                </div><!-- .chat -->
                                            @endif
                                        @endforeach
                                    </div><!-- .nk-chat-panel -->
                                    {{-- <form method="POST" action="{{route('store.staff.reply', $order->id)}}">
                                        {{ csrf_field() }}
                                        <div class="nk-chat-editor">
                                            <div class="nk-chat-editor-form">
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control form-control-simple no-resize" rows="1" id="comment" name="comment" placeholder="Type your message..."></textarea>
                                                </div>
                                            </div>
                                            <ul class="nk-chat-editor-tools g-2">
                                                <li>
                                                    <button type="submit" class="btn btn-round btn-primary btn-icon"><em class="icon ni ni-send-alt"></em></button>
                                                </li>
                                            </ul>
                                        </div><!-- .nk-chat-editor -->
                                    </form> --}}
                                </div><!-- .nk-chat-body -->
                            </div><!-- .nk-chat -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

@endsection
