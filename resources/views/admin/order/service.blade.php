@extends('layouts.admindashboard')
@section('title', $page_title)

@section('content')

            @php
                $sc = \App\Models\Order::where(['status' => 1])->count();
            @endphp
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
                                            <p>You have <b>{{$sc}}</b> Service in Progress.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered card-stretch">
                                    <div class="card-inner-group">
                                        <div class="card-inner p-0">
                                            <table class="nk-tb-list nk-tb-ulist">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                        <th class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input" id="pid-all">
                                                                <label class="custom-control-label" for="pid-all"></label>
                                                            </div>
                                                        </th>
                                                        <th class="nk-tb-col"><span class="sub-text">Service Name</span></th>
                                                        <th class="nk-tb-col tb-col-xxl"><span class="sub-text">Client</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Team Lead</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Team</span></th>
                                                        <th class="nk-tb-col tb-col-xxl"><span class="sub-text">Status</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Progress</span></th>
                                                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Deadline</span></th>
                                                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Invoice</span></th>
                                                        <th class="nk-tb-col nk-tb-col-tools text-right">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-xs btn-trigger btn-icon dropdown-toggle mr-n1" data-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-more-h"></em></a>
                                                            </div>
                                                        </th>
                                                    </tr><!-- .nk-tb-item -->
                                                </thead>
                                                <tbody>
                                                    @foreach($orders as $key => $data)
                                                        <tr class="nk-tb-item">
                                                            <td class="nk-tb-col nk-tb-col-check">
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input" id="pid-01">
                                                                    <label class="custom-control-label" for="pid-01"></label>
                                                                </div>
                                                            </td>
                                                            <td class="nk-tb-col">
                                                                <a href="{{ route('service.details',$data->id) }}" class="project-title">
                                                                    @if($data->price ==0)
                                                                        <div class="user-avatar sq bg-purple"><span>FREE</span></div>
                                                                    @else
                                                                        <div class="user-avatar sq bg-purple"><span>PAID</span></div>
                                                                    @endif
                                                                    <div class="project-info">
                                                                        <h6 class="title" data-toggle="tooltip" title="Order ID: {{$data->id}}">{{$data->service->name}}</h6>
                                                                    </div>
                                                                </a>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-xxl">
                                                                <span>Staff</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg">
                                                                @if($data->staff_id != 0)
                                                                    <span>{{$data->staff->name}}</span>
                                                                @else
                                                                    <span>Not Assign Yet</span>
                                                                @endif
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg">
                                                                <ul class="project-users g-1">
                                                                    <li>
                                                                        @if($data->staff_id != 0)
                                                                            @if(file_exists($data->staff->image))
                                                                                <div class="user-avatar sm bg-primary" data-toggle="tooltip" title="{{$data->staff->name}}"><img src="{{url($data->staff->image)}}" alt="{{$data->staff->name}}"></div>
                                                                            @else
                                                                                <div class="user-avatar sm bg-primary" data-toggle="tooltip" title="{{$data->staff->name}}"><img src="{{url('assets/images/profile.png')}}" alt="{{$data->staff->name}}"></div>
                                                                            @endif
                                                                        @else
                                                                            <div class="user-avatar sm bg-primary" data-toggle="tooltip" title="Not Assigned Yet"><img src="" alt=""></div>
                                                                        @endif
                                                                    </li>
                                                                    <li>
                                                                        @if($data->sstaff_id != 0)
                                                                            @if(file_exists($data->sstaff->image))
                                                                                <div class="user-avatar sm bg-primary" data-toggle="tooltip" title="{{$data->sstaff->name}}"><img src="{{url($data->sstaff->image)}}" alt="{{$data->sstaff->name}}"></div>
                                                                            @else
                                                                                <div class="user-avatar sm bg-primary" data-toggle="tooltip" title="{{$data->sstaff->name}}"><img src="{{url('assets/images/profile.png')}}" alt="{{$data->sstaff->name}}"></div>
                                                                            @endif
                                                                        @else
                                                                            <div class="user-avatar sm bg-primary" data-toggle="tooltip" title="Not Assigned Yet"><img src="" alt=""></div>
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-xxl">
                                                                @if($data->status ==1)
                                                                    <span>Open</span>
                                                                @else
                                                                    <span>Close</span>
                                                                @endif
                                                            </td>
                                                            @php
                                                                $cent = ($data->task / $data->service->task)*100;
                                                            @endphp
                                                            <td class="nk-tb-col tb-col-md">
                                                                <div class="project-list-progress">
                                                                    <div class="progress progress-pill progress-md bg-light">
                                                                        <div class="progress-bar" data-progress="{{$cent}}" data-toggle="tooltip" title="{{$data->task}} of {{$data->service->task}} tasks"></div>
                                                                    </div>
                                                                    <div class="project-progress-percent" data-toggle="tooltip" title="{{$data->task}} of {{$data->service->task}} tasks">{{$cent}}%</div>
                                                                </div>
                                                            </td>
                                                            @php
                                                                $days = $data->end;
                                                                $end = $timenow->diffInDays($days) + 1;
                                                            @endphp
                                                            <td class="nk-tb-col tb-col-mb">
                                                                @if($data->end < $timenow)
                                                                    <span class="badge badge-dim badge-success" data-toggle="tooltip" title="{{$data->end}}"><em class="icon ni ni-clock"></em><span>Done</span></span>
                                                                @elseif($timenow->diffInHours($days) < 12)
                                                                    <span class="badge badge-dim badge-danger" data-toggle="tooltip" title="{{$data->end}}"><em class="icon ni ni-clock"></em><span>Due Today</span></span>
                                                                @elseif($end > 5)
                                                                    <span class="badge badge-dim badge-light text-gray" data-toggle="tooltip" title="{{$data->end}}"><em class="icon ni ni-clock"></em><span>{{$end}} Days Left</span></span>
                                                                @elseif($end == 5)
                                                                    <span class="badge badge-dim badge-warning" data-toggle="tooltip" title="{{$data->end}}"><em class="icon ni ni-clock"></em><span>{{$end}} Days Left</span></span>
                                                                @elseif($end == 4)
                                                                    <span class="badge badge-dim badge-warning" data-toggle="tooltip" title="{{$data->end}}"><em class="icon ni ni-clock"></em><span>{{$end}} Days Left</span></span>
                                                                @elseif($end == 3)
                                                                    <span class="badge badge-dim badge-warning" data-toggle="tooltip" title="{{$data->end}}"><em class="icon ni ni-clock"></em><span>{{$end}} Days Left</span></span>
                                                                @elseif($end == 2)
                                                                    <span class="badge badge-dim badge-warning" data-toggle="tooltip" title="{{$data->end}}"><em class="icon ni ni-clock"></em><span>{{$end}} Days Left</span></span>
                                                                @elseif($end == 1)
                                                                    <span class="badge badge-dim badge-danger" data-toggle="tooltip" title="{{$data->end}}"><em class="icon ni ni-clock"></em><span>Due Tomorrow</span></span>
                                                                @endif
                                                            </td>
                                                            <td class="nk-tb-col tb-col-mb">
                                                                @if($data->invoice->status == 1)
                                                                    <span class="badge badge-dim badge-success" data-toggle="tooltip" title="Trx: {{$data->invoice_trx}}"><em class="icon ni ni-clock"></em><span>Paid</span></span>
                                                                @elseif($data->invoice->status == 2)
                                                                    <span class="badge badge-dim badge-primary" data-toggle="tooltip" title="Trx: {{$data->invoice_trx}}"><em class="icon ni ni-clock"></em><span>Pending Confirmation</span></span>
                                                                @else
                                                                    <span class="badge badge-dim badge-warning" data-toggle="tooltip" title="Trx: {{$data->invoice_trx}}"><em class="icon ni ni-clock"></em><span>Unpaid</span></span>
                                                                @endif
                                                            </td>
                                                            <td class="nk-tb-col nk-tb-col-tools">
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li><a href="{{ route('service.details',$data->id) }}"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                                    <li><a href="{{ route('invoice.details',$data->invoice_trx) }}"><em class="icon ni ni-printer"></em><span>View Invoice</span></a></li>
                                                                                    @if($data->staff_id ==0 || $data->sstaff_id ==0)
                                                                                        <li><a href="#assignTeam-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-user-check"></em><span>Assign Team</span></a></li>
                                                                                    @endif
                                                                                    <li><a href="#deadline-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-printer"></em><span>Change Deadline</span></a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr><!-- .nk-tb-item -->
                                                    @endforeach
                                                </tbody>
                                            </table><!-- .nk-tb-list -->
                                        </div><!-- .card-inner -->
                                        @include('pagination.default', ['paginator' => $orders])
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

        {{-- Assign Team Member --}}
        @foreach($orders as $key => $data)
            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="assignTeam-{{$data->id}}">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Team to Order</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('add.team-member')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control form-control-lg" name="id" value="{{$data->id}}">
                                <div class="form-group">
                                    <label class="form-label" for="lead">Team Lead</label>
                                    <div class="form-control-wrap ">
                                        <select class="form-control form-select" id="lead" name="staff_id" data-placeholder="Select Team Lead" required>
                                            <option label="Select Team Lead" value="0"></option>
                                            @foreach($staffs as $key => $lead)
                                                <option value="{{$lead->id}}">{{$lead->name}} ({{$lead->username}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="support">Team Support</label>
                                    <div class="form-control-wrap ">
                                        <select class="form-control form-select" id="support" name="sstaff_id" data-placeholder="Select Team Support">
                                            <option label="Select Team Support" value="0"></option>
                                            @foreach($staffs as $key => $support)
                                                <option value="{{$support->id}}">{{$support->name}} ({{$support->username}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Add Team Member</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Add Staff to Client Order</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Change Deadline --}}
        @foreach($orders as $key => $data)
            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="deadline-{{$data->id}}">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Order Deadline</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('update.deadline')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control form-control-lg" name="id" value="{{$data->id}}">
                                <div class="text-center">
                                    <h4>{{$data->end}}</h4>
                                    <code class="text-center">Current Deadline Date</code>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="new-date">Add Days to Current Deadline</label>
                                    <div class="form-control-wrap">
                                        <input type="number" step="1" class="form-control" id="new-date" name="days">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Change Date</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Order Deadline Update</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection
