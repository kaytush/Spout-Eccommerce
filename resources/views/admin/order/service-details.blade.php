@extends('layouts.admindashboard')
@section('title', 'Service Details')

@section('content')
<script>
    function goBack() {
    window.history.back()
    }
</script>
            <!-- content @s -->
            <div class="nk-content nk-content-lg nk-content-fluid">
                <div class="container-xl wide-lg">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <div class="nk-block-head-sub"><a href="#" data-toggle="modal" onclick="goBack()" class="text-soft back-to"><em class="icon ni ni-arrow-left"> </em><span>Back to Services</span></a></div>
                                    <div class="nk-block-between-md g-4">
                                        <div class="nk-block-head-content">
                                            <h2 class="nk-block-title fw-normal">{{$order->service->name}}</h2>
                                            <div class="nk-block-des">
                                                <p>#{{$order->invoice_trx}} @if($order->invoice->status == 1)<span class="badge badge-outline badge-success">Paid</span>@elseif($order->invoice->status == 2)<span class="badge badge-outline badge-primary">Waiting Approval</span>@else <span class="badge badge-outline badge-danger">Unpaid</span>@endif</p>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="nk-block-tools gx-3">
                                                {{-- <li class="order-md-last"><a href="#task" data-toggle="modal" class="btn btn-primary"><em class="icon ni ni-chevrons-right"></em> <span>Update Task</span> </a></li> --}}
                                                <li><a href="javascript:window.location.href=window.location.href" class="btn btn-icon btn-light"><em class="icon ni ni-reload"></em></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="row gy-gs">
                                            <div class="col-md-6">
                                                <div class="nk-iv-wg3">
                                                    <div class="nk-iv-wg3-group flex-lg-nowrap gx-4">
                                                        <div class="nk-iv-wg3-sub">
                                                            <div class="nk-iv-wg3-amount">
                                                                <div class="number">@if($order->price == 0)FREE @else {{$basic->currency_sym}}{{number_format($order->price, $basic->decimal)}} @endif</div>
                                                            </div>
                                                            <div class="nk-iv-wg3-subtitle">Service Cost</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .col -->
                                            <div class="col-md-6 col-lg-4 offset-lg-2">
                                                <div class="nk-iv-wg3 pl-md-3">
                                                    <div class="nk-iv-wg3-group flex-lg-nowrap gx-4">
                                                        <div class="nk-iv-wg3-sub">
                                                            <div class="nk-iv-wg3-amount">
                                                                <div class="number">@if($order->end < $timenow && $order->status == 1)Completed @elseif($order->status == 1)Active @elseif($order->status == 0)Pending @elseif($order->status == 2)Cancelled @endif</div>
                                                            </div>
                                                            <div class="nk-iv-wg3-subtitle">Service Status</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .col -->
                                        </div><!-- .row -->
                                    </div>
                                    <div id="schemeDetails" class="nk-iv-scheme-details">
                                        <ul class="nk-iv-wg3-list">
                                            <li>
                                                <div class="sub-text">Task</div>
                                                <div class="lead-text">{{$order->service->task}} @if($order->service->task == 1)Task @else Tasks @endif</div>
                                            </li>
                                            <li>
                                                <div class="sub-text">Service Category</div>
                                                <div class="lead-text">{{$order->cat->name}}</div>
                                            </li>
                                        </ul><!-- .nk-iv-wg3-list -->
                                        <ul class="nk-iv-wg3-list">
                                            <li>
                                                <div class="sub-text">Ordered date</div>
                                                <div class="lead-text">{!! date('M d, Y H:i A', strtotime($order->created_at)) !!}</div>
                                            </li>
                                            <li>
                                                <div class="sub-text">End date</div>
                                                <div class="lead-text">{!! date('M d, Y H:i A', strtotime($order->end)) !!}</div>
                                            </li>
                                        </ul><!-- .nk-iv-wg3-list -->
                                        <ul class="nk-iv-wg3-list">
                                            <li>
                                                <div class="sub-text">Team Lead</div>
                                                <div class="lead-text">@if($order->staff_id != 0){{$order->staff->name}}@else Not Assign Yet @endif</div>
                                            </li>
                                            <li>
                                                <div class="sub-text">Team Support</div>
                                                <div class="lead-text">@if($order->sstaff_id != 0){{$order->sstaff->name}}@else Not Assign Yet @endif</div>
                                            </li>
                                        </ul><!-- .nk-iv-wg3-list -->
                                    </div><!-- .nk-iv-scheme-details -->
                                </div>
                            </div><!-- .nk-block -->
                            <div class="nk-block nk-block-lg">
                                <div class="nk-block-head">
                                    <h5 class="nk-block-title">Graph View</h5>
                                </div>
                                @php
                                    $cent = ($order->task / $order->service->task)*100;
                                    $days = $order->end;
                                    $end = $timenow->diffInDays($days);
                                    $dcent = ($end / $order->service->duration)*100;
                                @endphp
                                <div class="row g-gs">
                                    <div class="col-lg col-lg-6">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner justify-center text-center h-100">
                                                <div class="nk-iv-wg5">
                                                    <div class="nk-iv-wg5-head">
                                                        <h5 class="nk-iv-wg5-title">Tasks</h5>
                                                        <div class="nk-iv-wg5-subtitle">Percentage by <strong>Task</strong> Completed</div>
                                                    </div>
                                                    <div class="nk-iv-wg5-ck sm">
                                                        <input type="text" class="knob-half" value="{{$cent}}" data-fgColor="#33d895" data-bgColor="#d9e5f7" data-thickness=".07" data-width="240" data-height="125" data-displayInput="false">
                                                        <div class="nk-iv-wg5-ck-result">
                                                            <div class="text-lead sm">{{$cent}}%</div>
                                                            <div class="text-sub">Task Completion</div>
                                                        </div>
                                                        <div class="nk-iv-wg5-ck-minmax"><span>0</span><span>{{$order->service->task}}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-lg col-lg-6">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner justify-center text-center h-100">
                                                <div class="nk-iv-wg5">
                                                    <div class="nk-iv-wg5-head">
                                                        <h5 class="nk-iv-wg5-title">Day Remain</h5>
                                                        <div class="nk-iv-wg5-subtitle">Days left to end of Service</div>
                                                    </div>
                                                    <div class="nk-iv-wg5-ck sm">
                                                        <input type="text" class="knob-half" value="{{$dcent}}" data-fgColor="#816bff" data-bgColor="#d9e5f7" data-thickness=".07" data-width="240" data-height="125" data-displayInput="false">
                                                        <div class="nk-iv-wg5-ck-result">
                                                            <div class="text-lead sm">{{$end}} D</div>
                                                            <div class="text-sub">day remain</div>
                                                        </div>
                                                        <div class="nk-iv-wg5-ck-minmax"><span>0</span><span>{{$order->service->duration}}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->
                            </div><!-- .nk-block -->
                            <div class="nk-block">
                                <div class="card card-bordered">
                                    <div class="card-inner card-inner-lg">
                                        <div class="nk-kyc-app p-sm-2 text-center">
                                            <div class="nk-kyc-app-action">
                                                <a style="margin-bottom: 10px; margin-left: 5px; margin-right: 5px; margin-top: 10px;" href="{{route('service.message', $order->id)}}" class="btn btn-lg btn-primary"><em class="icon ni ni-chat"></em><span>Read Client Staff Message</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                                <div class="text-center pt-4">
                                    <p>If you have any question, please contact our support team <a href="{{$basic->email}}">{{$basic->email}}</a></p>
                                </div>
                            </div> <!-- .nk-block -->
                            <div class="nk-fmg-quick-list nk-block">
                                <div class="nk-block-head-xs">
                                    <div class="nk-block-between g-2">
                                        <div class="nk-block-head-content">
                                            <h6 class="nk-block-title title">Quick Access</h6>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <a href="#" class="link link-primary toggle-opt active" data-target="quick-access">
                                                <div class="inactive-text">Show</div>
                                                <div class="active-text">Hide</div>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="toggle-expand-content expanded" data-content="quick-access">
                                    <div class="nk-files nk-files-view-grid">
                                        <div class="nk-files-list">
                                            @foreach ($xfiles as $data)
                                                @php
                                                    $ext = substr($data->link, strrpos($data->link, '.' )+1);
                                                @endphp
                                                <div class="nk-file-item nk-file">
                                                    <div class="nk-file-info">
                                                        <a href="{{url($data->link)}}" class="nk-file-link" download>
                                                            <div class="nk-file-title">
                                                                <div class="nk-file-icon">
                                                                    <span class="nk-file-icon-type">
                                                                        @if ($ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'svg')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                <g>
                                                                                    <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#755de0" />
                                                                                    <path d="M27.2223,43H44.7086s2.325-.2815.7357-1.897l-5.6034-5.4985s-1.5115-1.7913-3.3357.7933L33.56,40.4707a.6887.6887,0,0,1-1.0186.0486l-1.9-1.6393s-1.3291-1.5866-2.4758,0c-.6561.9079-2.0261,2.8489-2.0261,2.8489S25.4268,43,27.2223,43Z" style="fill:#fff" />
                                                                                    <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#b5b3ff" />
                                                                                </g>
                                                                            </svg>
                                                                        @elseif ($ext == 'pdf')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#f26b6b" />
                                                                                <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#f4c9c9" />
                                                                                <path d="M46.3342,44.5381a4.326,4.326,0,0,0-2.5278-1.4289,22.436,22.436,0,0,0-4.5619-.3828A19.3561,19.3561,0,0,1,35.82,37.9536a56.5075,56.5075,0,0,0,1.3745-6.0858,2.339,2.339,0,0,0-.4613-1.8444,1.9429,1.9429,0,0,0-1.5162-.753h-.0014a1.6846,1.6846,0,0,0-1.3893.6966c-1.1493,1.5257-.3638,5.219-.1941,5.9457a12.6118,12.6118,0,0,0,.7236,2.1477,33.3221,33.3221,0,0,1-2.49,6.1052,20.3467,20.3467,0,0,0-5.9787,3.4413,2.5681,2.5681,0,0,0-.8861,1.8265,1.8025,1.8025,0,0,0,.6345,1.3056,2.0613,2.0613,0,0,0,1.3942.5313,2.2436,2.2436,0,0,0,1.4592-.5459,20.0678,20.0678,0,0,0,4.2893-5.3578,20.8384,20.8384,0,0,1,5.939-1.1858A33.75,33.75,0,0,0,42.96,47.7858,2.6392,2.6392,0,0,0,46.376,47.55,2.08,2.08,0,0,0,46.3342,44.5381ZM27.6194,49.6234a.8344.8344,0,0,1-1.0847.0413.4208.4208,0,0,1-.1666-.2695c-.0018-.0657.0271-.3147.4408-.736a18.0382,18.0382,0,0,1,3.7608-2.368A17.26,17.26,0,0,1,27.6194,49.6234ZM34.9023,30.848a.343.343,0,0,1,.3144-.1514.6008.6008,0,0,1,.4649.2389.853.853,0,0,1,.1683.6722v0c-.1638.92-.4235,2.381-.8523,4.1168-.0125-.05-.0249-.1-.037-.1506C34.6053,34.0508,34.3523,31.5779,34.9023,30.848ZM33.7231,43.5507a34.9732,34.9732,0,0,0,1.52-3.7664,21.2484,21.2484,0,0,0,2.2242,3.05A21.8571,21.8571,0,0,0,33.7231,43.5507Zm11.7054,2.97a1.3085,1.3085,0,0,1-1.6943.0887,33.2027,33.2027,0,0,1-3.0038-2.43,20.9677,20.9677,0,0,1,2.8346.3335,2.97,2.97,0,0,1,1.7406.9647C45.8377,46.1115,45.6013,46.3483,45.4285,46.5212Z" style="fill:#fff" />
                                                                            </svg>
                                                                        @elseif ($ext == 'docx')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                <g>
                                                                                    <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#599def" />
                                                                                    <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#c2e1ff" />
                                                                                    <rect x="27" y="31" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                    <rect x="27" y="36" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                    <rect x="27" y="41" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                    <rect x="27" y="46" width="12" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                </g>
                                                                            </svg>
                                                                        @elseif ($ext == 'zip')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                <g>
                                                                                    <rect x="18" y="16" width="36" height="40" rx="5" ry="5" style="fill:#e3edfc" />
                                                                                    <path d="M19.03,54A4.9835,4.9835,0,0,0,23,56H49a4.9835,4.9835,0,0,0,3.97-2Z" style="fill:#c4dbf2" />
                                                                                    <rect x="32" y="20" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                    <rect x="32" y="25" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                    <rect x="32" y="30" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                    <rect x="32" y="35" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                    <path d="M35,16.0594h2a0,0,0,0,1,0,0V41a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V16.0594A0,0,0,0,1,35,16.0594Z" style="fill:#7e95c4" />
                                                                                    <path d="M38.0024,40H33.9976A1.9976,1.9976,0,0,0,32,41.9976v2.0047A1.9976,1.9976,0,0,0,33.9976,46h4.0047A1.9976,1.9976,0,0,0,40,44.0024V41.9976A1.9976,1.9976,0,0,0,38.0024,40Zm-.0053,4H34V42h4Z" style="fill:#7e95c4" />
                                                                                </g>
                                                                            </svg>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="nk-file-name">
                                                                    <div class="nk-file-name-text">
                                                                        <span href="{{url($data->link)}}" class="title">{{$data->title}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="nk-file-actions hideable">
                                                        <a href="{{url($data->link)}}" class="btn btn-sm btn-icon btn-trigger"><em class="icon ni ni-cross"></em></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div><!-- .nk-files -->
                                </div>
                            </div>
                            <div class="nk-fmg-listing nk-block-lg">
                                <div class="nk-block-head-xs">
                                    <div class="nk-block-between g-2">
                                        <div class="nk-block-head-content">
                                            <h6 class="nk-block-title title">Browse Files</h6>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="nk-block-tools g-3 nav">
                                                <li><a data-toggle="tab" href="#file-grid-view" class="nk-switch-icon"><em class="icon ni ni-view-grid3-wd"></em></a></li>
                                                <li><a data-toggle="tab" href="#file-group-view" class="nk-switch-icon"><em class="icon ni ni-view-group-wd"></em></a></li>
                                                <li><a data-toggle="tab" href="#file-list-view" class="nk-switch-icon active"><em class="icon ni ni-view-row-wd"></em></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="tab-content">
                                    <div class="tab-pane" id="file-grid-view">
                                        <div class="nk-files nk-files-view-grid">
                                            <div class="nk-files-list">
                                                @foreach ($files as $data)
                                                    @php
                                                        $ext = substr($data->link, strrpos($data->link, '.' )+1);
                                                    @endphp
                                                    <div class="nk-file-item nk-file">
                                                        <div class="nk-file-info">
                                                            <div class="nk-file-title">
                                                                <div class="nk-file-icon">
                                                                    <a class="nk-file-icon-link" href="#">
                                                                        <span class="nk-file-icon-type">
                                                                            @if ($ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'svg')
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                    <g>
                                                                                        <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#755de0" />
                                                                                        <path d="M27.2223,43H44.7086s2.325-.2815.7357-1.897l-5.6034-5.4985s-1.5115-1.7913-3.3357.7933L33.56,40.4707a.6887.6887,0,0,1-1.0186.0486l-1.9-1.6393s-1.3291-1.5866-2.4758,0c-.6561.9079-2.0261,2.8489-2.0261,2.8489S25.4268,43,27.2223,43Z" style="fill:#fff" />
                                                                                        <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#b5b3ff" />
                                                                                    </g>
                                                                                </svg>
                                                                            @elseif ($ext == 'pdf')
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                    <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#f26b6b" />
                                                                                    <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#f4c9c9" />
                                                                                    <path d="M46.3342,44.5381a4.326,4.326,0,0,0-2.5278-1.4289,22.436,22.436,0,0,0-4.5619-.3828A19.3561,19.3561,0,0,1,35.82,37.9536a56.5075,56.5075,0,0,0,1.3745-6.0858,2.339,2.339,0,0,0-.4613-1.8444,1.9429,1.9429,0,0,0-1.5162-.753h-.0014a1.6846,1.6846,0,0,0-1.3893.6966c-1.1493,1.5257-.3638,5.219-.1941,5.9457a12.6118,12.6118,0,0,0,.7236,2.1477,33.3221,33.3221,0,0,1-2.49,6.1052,20.3467,20.3467,0,0,0-5.9787,3.4413,2.5681,2.5681,0,0,0-.8861,1.8265,1.8025,1.8025,0,0,0,.6345,1.3056,2.0613,2.0613,0,0,0,1.3942.5313,2.2436,2.2436,0,0,0,1.4592-.5459,20.0678,20.0678,0,0,0,4.2893-5.3578,20.8384,20.8384,0,0,1,5.939-1.1858A33.75,33.75,0,0,0,42.96,47.7858,2.6392,2.6392,0,0,0,46.376,47.55,2.08,2.08,0,0,0,46.3342,44.5381ZM27.6194,49.6234a.8344.8344,0,0,1-1.0847.0413.4208.4208,0,0,1-.1666-.2695c-.0018-.0657.0271-.3147.4408-.736a18.0382,18.0382,0,0,1,3.7608-2.368A17.26,17.26,0,0,1,27.6194,49.6234ZM34.9023,30.848a.343.343,0,0,1,.3144-.1514.6008.6008,0,0,1,.4649.2389.853.853,0,0,1,.1683.6722v0c-.1638.92-.4235,2.381-.8523,4.1168-.0125-.05-.0249-.1-.037-.1506C34.6053,34.0508,34.3523,31.5779,34.9023,30.848ZM33.7231,43.5507a34.9732,34.9732,0,0,0,1.52-3.7664,21.2484,21.2484,0,0,0,2.2242,3.05A21.8571,21.8571,0,0,0,33.7231,43.5507Zm11.7054,2.97a1.3085,1.3085,0,0,1-1.6943.0887,33.2027,33.2027,0,0,1-3.0038-2.43,20.9677,20.9677,0,0,1,2.8346.3335,2.97,2.97,0,0,1,1.7406.9647C45.8377,46.1115,45.6013,46.3483,45.4285,46.5212Z" style="fill:#fff" />
                                                                                </svg>
                                                                            @elseif ($ext == 'docx')
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                    <g>
                                                                                        <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#599def" />
                                                                                        <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#c2e1ff" />
                                                                                        <rect x="27" y="31" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                        <rect x="27" y="36" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                        <rect x="27" y="41" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                        <rect x="27" y="46" width="12" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                    </g>
                                                                                </svg>
                                                                            @elseif ($ext == 'zip')
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                    <g>
                                                                                        <rect x="18" y="16" width="36" height="40" rx="5" ry="5" style="fill:#e3edfc" />
                                                                                        <path d="M19.03,54A4.9835,4.9835,0,0,0,23,56H49a4.9835,4.9835,0,0,0,3.97-2Z" style="fill:#c4dbf2" />
                                                                                        <rect x="32" y="20" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                        <rect x="32" y="25" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                        <rect x="32" y="30" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                        <rect x="32" y="35" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                        <path d="M35,16.0594h2a0,0,0,0,1,0,0V41a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V16.0594A0,0,0,0,1,35,16.0594Z" style="fill:#7e95c4" />
                                                                                        <path d="M38.0024,40H33.9976A1.9976,1.9976,0,0,0,32,41.9976v2.0047A1.9976,1.9976,0,0,0,33.9976,46h4.0047A1.9976,1.9976,0,0,0,40,44.0024V41.9976A1.9976,1.9976,0,0,0,38.0024,40Zm-.0053,4H34V42h4Z" style="fill:#7e95c4" />
                                                                                    </g>
                                                                                </svg>
                                                                            @endif
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <div class="nk-file-name">
                                                                    <div class="nk-file-name-text">
                                                                        <a href="{{url($data->link)}}" class="title">{{$data->title}}</a>
                                                                        <div class="asterisk"><a href="{{url($data->link)}}"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $bytes = $data->filesize;

                                                                if ($bytes >= 1073741824)
                                                                {
                                                                    $fileSize = number_format($bytes / 1073741824, 2) . ' GB';
                                                                }
                                                                elseif ($bytes >= 1048576)
                                                                {
                                                                    $fileSize = number_format($bytes / 1048576, 2) . ' MB';
                                                                }
                                                                elseif ($bytes >= 1024)
                                                                {
                                                                    $fileSize = number_format($bytes / 1024, 2) . ' KB';
                                                                }
                                                                elseif ($bytes > 1)
                                                                {
                                                                    $fileSize = $bytes . ' bytes';
                                                                }
                                                                elseif ($bytes == 1)
                                                                {
                                                                    $fileSize = $bytes . ' byte';
                                                                }
                                                                else
                                                                {
                                                                    $fileSize = '0 bytes';
                                                                }
                                                            @endphp
                                                            <ul class="nk-file-desc">
                                                                <li class="date">{{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</li>
                                                                <li class="size">{{$fileSize}}</li>
                                                                <li class="members">
                                                                    @if ($data->upload_by == 'staff')
                                                                        {{$data->staff->name}}
                                                                    @else
                                                                        {{$order->user->firstname.' '.$order->user->lastname}}
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="nk-file-actions">
                                                            <div class="dropdown">
                                                                <a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-plain no-bdr">
                                                                        <li><a href="{{url($data->link)}}" target="_blank"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                        <li><a href="{url($data->link)}}" class="file-dl-toast" download><em class="icon ni ni-download"></em><span>Download</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .nk-file -->
                                                @endforeach
                                            </div>
                                        </div><!-- .nk-files -->
                                    </div><!-- .tab-pane -->
                                    <div class="tab-pane" id="file-group-view">
                                        <div class="nk-files nk-files-view-group">
                                            <div class="nk-files-group">
                                                <h6 class="title">Files</h6>
                                                <div class="nk-files-list">
                                                    @foreach ($files as $data)
                                                        @php
                                                            $ext = substr($data->link, strrpos($data->link, '.' )+1);
                                                        @endphp
                                                        <div class="nk-file-item nk-file">
                                                            <div class="nk-file-info">
                                                                <div class="nk-file-title">
                                                                    <div class="nk-file-icon">
                                                                        <span class="nk-file-icon-type">
                                                                            @if ($ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'svg')
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                    <g>
                                                                                        <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#755de0" />
                                                                                        <path d="M27.2223,43H44.7086s2.325-.2815.7357-1.897l-5.6034-5.4985s-1.5115-1.7913-3.3357.7933L33.56,40.4707a.6887.6887,0,0,1-1.0186.0486l-1.9-1.6393s-1.3291-1.5866-2.4758,0c-.6561.9079-2.0261,2.8489-2.0261,2.8489S25.4268,43,27.2223,43Z" style="fill:#fff" />
                                                                                        <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#b5b3ff" />
                                                                                    </g>
                                                                                </svg>
                                                                            @elseif ($ext == 'pdf')
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                    <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#f26b6b" />
                                                                                    <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#f4c9c9" />
                                                                                    <path d="M46.3342,44.5381a4.326,4.326,0,0,0-2.5278-1.4289,22.436,22.436,0,0,0-4.5619-.3828A19.3561,19.3561,0,0,1,35.82,37.9536a56.5075,56.5075,0,0,0,1.3745-6.0858,2.339,2.339,0,0,0-.4613-1.8444,1.9429,1.9429,0,0,0-1.5162-.753h-.0014a1.6846,1.6846,0,0,0-1.3893.6966c-1.1493,1.5257-.3638,5.219-.1941,5.9457a12.6118,12.6118,0,0,0,.7236,2.1477,33.3221,33.3221,0,0,1-2.49,6.1052,20.3467,20.3467,0,0,0-5.9787,3.4413,2.5681,2.5681,0,0,0-.8861,1.8265,1.8025,1.8025,0,0,0,.6345,1.3056,2.0613,2.0613,0,0,0,1.3942.5313,2.2436,2.2436,0,0,0,1.4592-.5459,20.0678,20.0678,0,0,0,4.2893-5.3578,20.8384,20.8384,0,0,1,5.939-1.1858A33.75,33.75,0,0,0,42.96,47.7858,2.6392,2.6392,0,0,0,46.376,47.55,2.08,2.08,0,0,0,46.3342,44.5381ZM27.6194,49.6234a.8344.8344,0,0,1-1.0847.0413.4208.4208,0,0,1-.1666-.2695c-.0018-.0657.0271-.3147.4408-.736a18.0382,18.0382,0,0,1,3.7608-2.368A17.26,17.26,0,0,1,27.6194,49.6234ZM34.9023,30.848a.343.343,0,0,1,.3144-.1514.6008.6008,0,0,1,.4649.2389.853.853,0,0,1,.1683.6722v0c-.1638.92-.4235,2.381-.8523,4.1168-.0125-.05-.0249-.1-.037-.1506C34.6053,34.0508,34.3523,31.5779,34.9023,30.848ZM33.7231,43.5507a34.9732,34.9732,0,0,0,1.52-3.7664,21.2484,21.2484,0,0,0,2.2242,3.05A21.8571,21.8571,0,0,0,33.7231,43.5507Zm11.7054,2.97a1.3085,1.3085,0,0,1-1.6943.0887,33.2027,33.2027,0,0,1-3.0038-2.43,20.9677,20.9677,0,0,1,2.8346.3335,2.97,2.97,0,0,1,1.7406.9647C45.8377,46.1115,45.6013,46.3483,45.4285,46.5212Z" style="fill:#fff" />
                                                                                </svg>
                                                                            @elseif ($ext == 'docx')
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                    <g>
                                                                                        <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#599def" />
                                                                                        <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#c2e1ff" />
                                                                                        <rect x="27" y="31" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                        <rect x="27" y="36" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                        <rect x="27" y="41" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                        <rect x="27" y="46" width="12" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                    </g>
                                                                                </svg>
                                                                            @elseif ($ext == 'zip')
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                    <g>
                                                                                        <rect x="18" y="16" width="36" height="40" rx="5" ry="5" style="fill:#e3edfc" />
                                                                                        <path d="M19.03,54A4.9835,4.9835,0,0,0,23,56H49a4.9835,4.9835,0,0,0,3.97-2Z" style="fill:#c4dbf2" />
                                                                                        <rect x="32" y="20" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                        <rect x="32" y="25" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                        <rect x="32" y="30" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                        <rect x="32" y="35" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                        <path d="M35,16.0594h2a0,0,0,0,1,0,0V41a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V16.0594A0,0,0,0,1,35,16.0594Z" style="fill:#7e95c4" />
                                                                                        <path d="M38.0024,40H33.9976A1.9976,1.9976,0,0,0,32,41.9976v2.0047A1.9976,1.9976,0,0,0,33.9976,46h4.0047A1.9976,1.9976,0,0,0,40,44.0024V41.9976A1.9976,1.9976,0,0,0,38.0024,40Zm-.0053,4H34V42h4Z" style="fill:#7e95c4" />
                                                                                    </g>
                                                                                </svg>
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div class="nk-file-name">
                                                                        <div class="nk-file-name-text">
                                                                            <a href="{{url($data->link)}}" class="title">{{$data->title}}</a>
                                                                            <div class="asterisk"><a href="{{url($data->link)}}"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $bytes = $data->filesize;

                                                                    if ($bytes >= 1073741824)
                                                                    {
                                                                        $fileSize = number_format($bytes / 1073741824, 2) . ' GB';
                                                                    }
                                                                    elseif ($bytes >= 1048576)
                                                                    {
                                                                        $fileSize = number_format($bytes / 1048576, 2) . ' MB';
                                                                    }
                                                                    elseif ($bytes >= 1024)
                                                                    {
                                                                        $fileSize = number_format($bytes / 1024, 2) . ' KB';
                                                                    }
                                                                    elseif ($bytes > 1)
                                                                    {
                                                                        $fileSize = $bytes . ' bytes';
                                                                    }
                                                                    elseif ($bytes == 1)
                                                                    {
                                                                        $fileSize = $bytes . ' byte';
                                                                    }
                                                                    else
                                                                    {
                                                                        $fileSize = '0 bytes';
                                                                    }
                                                                @endphp
                                                                <ul class="nk-file-desc">
                                                                    <li class="date">{{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</li>
                                                                    <li class="size">{{$fileSize}}</li>
                                                                    <li class="members">
                                                                        @if ($data->upload_by == 'staff')
                                                                            {{$data->staff->name}}
                                                                        @else
                                                                            {{$order->user->firstname.' '.$order->user->lastname}}
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="nk-file-actions">
                                                                <div class="dropdown">
                                                                    <a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <ul class="link-list-plain no-bdr">
                                                                            <li><a href="{{url($data->link)}}" target="_blank"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                            <li><a href="{{url($data->link)}}" class="file-dl-toast" download><em class="icon ni ni-download"></em><span>Download</span></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- .nk-file -->
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div><!-- .nk-files -->
                                    </div><!-- .tab-pane -->
                                    <div class="tab-pane active" id="file-list-view">
                                        <div class="nk-files nk-files-view-list">
                                            <div class="nk-files-head">
                                                <div class="nk-file-item">
                                                    <div class="nk-file-info">
                                                        <div class="tb-head">Name</div>
                                                        <div class="tb-head"></div>
                                                    </div>
                                                    <div class="nk-file-meta">
                                                        <div class="dropdown">
                                                            <div class="tb-head">Upload Time</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-file-members">
                                                        <div class="tb-head">Uploaded By</div>
                                                    </div>
                                                    <div class="nk-file-actions">
                                                        <div class="dropdown">
                                                            <a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-files-head -->
                                            <div class="nk-files-list">
                                                @foreach ($files as $data)
                                                    @php
                                                        $ext = substr($data->link, strrpos($data->link, '.' )+1);
                                                    @endphp
                                                    <div class="nk-file-item nk-file">
                                                        <div class="nk-file-info">
                                                            <div class="nk-file-title">
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input" id="file-check-n1">
                                                                    <label class="custom-control-label" for="file-check-n1"></label>
                                                                </div>
                                                                <div class="nk-file-icon">
                                                                    <span class="nk-file-icon-type">
                                                                        @if ($ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'svg')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                <g>
                                                                                    <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#755de0" />
                                                                                    <path d="M27.2223,43H44.7086s2.325-.2815.7357-1.897l-5.6034-5.4985s-1.5115-1.7913-3.3357.7933L33.56,40.4707a.6887.6887,0,0,1-1.0186.0486l-1.9-1.6393s-1.3291-1.5866-2.4758,0c-.6561.9079-2.0261,2.8489-2.0261,2.8489S25.4268,43,27.2223,43Z" style="fill:#fff" />
                                                                                    <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#b5b3ff" />
                                                                                </g>
                                                                            </svg>
                                                                        @elseif ($ext == 'pdf')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#f26b6b" />
                                                                                <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#f4c9c9" />
                                                                                <path d="M46.3342,44.5381a4.326,4.326,0,0,0-2.5278-1.4289,22.436,22.436,0,0,0-4.5619-.3828A19.3561,19.3561,0,0,1,35.82,37.9536a56.5075,56.5075,0,0,0,1.3745-6.0858,2.339,2.339,0,0,0-.4613-1.8444,1.9429,1.9429,0,0,0-1.5162-.753h-.0014a1.6846,1.6846,0,0,0-1.3893.6966c-1.1493,1.5257-.3638,5.219-.1941,5.9457a12.6118,12.6118,0,0,0,.7236,2.1477,33.3221,33.3221,0,0,1-2.49,6.1052,20.3467,20.3467,0,0,0-5.9787,3.4413,2.5681,2.5681,0,0,0-.8861,1.8265,1.8025,1.8025,0,0,0,.6345,1.3056,2.0613,2.0613,0,0,0,1.3942.5313,2.2436,2.2436,0,0,0,1.4592-.5459,20.0678,20.0678,0,0,0,4.2893-5.3578,20.8384,20.8384,0,0,1,5.939-1.1858A33.75,33.75,0,0,0,42.96,47.7858,2.6392,2.6392,0,0,0,46.376,47.55,2.08,2.08,0,0,0,46.3342,44.5381ZM27.6194,49.6234a.8344.8344,0,0,1-1.0847.0413.4208.4208,0,0,1-.1666-.2695c-.0018-.0657.0271-.3147.4408-.736a18.0382,18.0382,0,0,1,3.7608-2.368A17.26,17.26,0,0,1,27.6194,49.6234ZM34.9023,30.848a.343.343,0,0,1,.3144-.1514.6008.6008,0,0,1,.4649.2389.853.853,0,0,1,.1683.6722v0c-.1638.92-.4235,2.381-.8523,4.1168-.0125-.05-.0249-.1-.037-.1506C34.6053,34.0508,34.3523,31.5779,34.9023,30.848ZM33.7231,43.5507a34.9732,34.9732,0,0,0,1.52-3.7664,21.2484,21.2484,0,0,0,2.2242,3.05A21.8571,21.8571,0,0,0,33.7231,43.5507Zm11.7054,2.97a1.3085,1.3085,0,0,1-1.6943.0887,33.2027,33.2027,0,0,1-3.0038-2.43,20.9677,20.9677,0,0,1,2.8346.3335,2.97,2.97,0,0,1,1.7406.9647C45.8377,46.1115,45.6013,46.3483,45.4285,46.5212Z" style="fill:#fff" />
                                                                            </svg>
                                                                        @elseif ($ext == 'docx')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                <g>
                                                                                    <path d="M50,61H22a6,6,0,0,1-6-6V22l9-11H50a6,6,0,0,1,6,6V55A6,6,0,0,1,50,61Z" style="fill:#599def" />
                                                                                    <path d="M25,20.556A1.444,1.444,0,0,1,23.556,22H16l9-11h0Z" style="fill:#c2e1ff" />
                                                                                    <rect x="27" y="31" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                    <rect x="27" y="36" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                    <rect x="27" y="41" width="18" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                    <rect x="27" y="46" width="12" height="2" rx="1" ry="1" style="fill:#fff" />
                                                                                </g>
                                                                            </svg>
                                                                        @elseif ($ext == 'zip')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                                                <g>
                                                                                    <rect x="18" y="16" width="36" height="40" rx="5" ry="5" style="fill:#e3edfc" />
                                                                                    <path d="M19.03,54A4.9835,4.9835,0,0,0,23,56H49a4.9835,4.9835,0,0,0,3.97-2Z" style="fill:#c4dbf2" />
                                                                                    <rect x="32" y="20" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                    <rect x="32" y="25" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                    <rect x="32" y="30" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                    <rect x="32" y="35" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4" />
                                                                                    <path d="M35,16.0594h2a0,0,0,0,1,0,0V41a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V16.0594A0,0,0,0,1,35,16.0594Z" style="fill:#7e95c4" />
                                                                                    <path d="M38.0024,40H33.9976A1.9976,1.9976,0,0,0,32,41.9976v2.0047A1.9976,1.9976,0,0,0,33.9976,46h4.0047A1.9976,1.9976,0,0,0,40,44.0024V41.9976A1.9976,1.9976,0,0,0,38.0024,40Zm-.0053,4H34V42h4Z" style="fill:#7e95c4" />
                                                                                </g>
                                                                            </svg>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="nk-file-name">
                                                                    <div class="nk-file-name-text">
                                                                        <a href="{{url($data->link)}}" class="title">{{$data->title}}</a>
                                                                        <div class="nk-file-star asterisk"><a href="{{url($data->link)}}"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-file-meta">
                                                            <div class="tb-lead">{{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</div>
                                                        </div>
                                                        <div class="nk-file-members">
                                                            <div class="tb-lead">
                                                                @if ($data->upload_by == 'staff')
                                                                    {{$data->staff->name}}
                                                                @else
                                                                    {{$order->user->firstname.' '.$order->user->lastname}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="nk-file-actions">
                                                            <div class="dropdown">
                                                                <a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-plain no-bdr">
                                                                        <li><a href="{{url($data->link)}}" target="_blank"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                        <li><a href="{{url($data->link)}}" class="file-dl-toast" download><em class="icon ni ni-download"></em><span>Download</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .nk-file -->
                                                @endforeach
                                            </div>
                                        </div><!-- .nk-files -->
                                    </div><!-- .tab-pane -->
                                </div><!-- .tab-content -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

@endsection
