@extends('layouts.admindashboard')
@section('title', 'Staffs')

@section('content')

            @php
                $all = \App\Models\Staff::count();
            @endphp
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Staff List</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>You have total <b>{{$all}}</b> Staffs.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    {{-- <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li> --}}
                                                    <li><a href="#addStaff" data-toggle="modal" class="btn btn-white btn-outline-primary"><em class="icon ni ni-plus"></em><span>Add Staff</span></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    @foreach($staffs as $key => $data)
                                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="team">
                                                        @if($data->status ==1)
                                                            <div class="team-status bg-success text-white"><em class="icon ni ni-check-thick"></em></div>
                                                        @else
                                                            <div class="team-status bg-danger text-white"><em class="icon ni ni-na"></em></div>
                                                        @endif
                                                        <div class="team-options">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#view-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                        <li><a href="{{ route('view.staff', $data->id) }}"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                        <li><a href="#editStaff-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-edit"></em><span>Edit Staff</span></a></li>
                                                                        <li><a href="#sendmail-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-mail"></em><span>Send Email</span></a></li>
                                                                        <li class="divider"></li>
                                                                        @if($data->status ==0)
                                                                            <li><a href="{{ route('activate.staff', $data->id) }}"><em class="icon ni ni-check-circle"></em><span>Unsuspend Staff</span></a></li>
                                                                        @else
                                                                            <li><a href="{{ route('deactivate.staff', $data->id) }}"><em class="icon ni ni-na"></em><span>Suspend Staff</span></a></li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="user-card user-card-s2">
                                                            <div class="user-avatar md bg-primary">
                                                                @if(file_exists($data->image))
                                                                    <img src="{{url($data->image)}}" alt="">
                                                                @else
                                                                    <img src="{{url('assets/images/profile.png')}}" alt="">
                                                                @endif
                                                                <div class="status dot dot-lg dot-success"></div>
                                                            </div>
                                                            <div class="user-info">
                                                                <h6>{{$data->name}}</h6>
                                                                <span class="sub-text">{{$data->username}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="team-details">
                                                            <p>{{$data->role}}</p>
                                                        </div>
                                                        <ul class="team-statistics">
                                                            <li><span>{{\App\Models\Order::where('staff_id',$data->id)->orwhere('sstaff_id',$data->id)->count()}}</span><span>Order Assigned</span></li>
                                                            <li><span>{{\App\Models\Order::where('staff_id',$data->id)->count()}}</span><span>Order Lead</span></li>
                                                            <li><span>{{\App\Models\Order::where('sstaff_id',$data->id)->count()}}</span><span>Order Support</span></li>
                                                        </ul>
                                                        <div class="team-view">
                                                            <a href="{{ route('view.staff', $data->id) }}" class="btn btn-round btn-outline-light w-150px"><span>View Profile</span></a>
                                                        </div>
                                                    </div><!-- .team -->
                                                </div><!-- .card-inner -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                    @endforeach
                                </div>
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="addStaff">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Staff</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('create-staff')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Fullname <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="name" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="username" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="email" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="phone" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="password" class="form-control form-control-lg" name="password" value="password" required readonly>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="role" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                                <div class="form-group  pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Create Staff</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Add New Staff / Lawyer</span>
                        </div>
                    </div>
                </div>
            </div>

        @foreach($staffs as $key => $data)
            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="sendmail-{{$data->id}}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Send Email to {{$data->name}}</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('staff.sendmail')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control" id="subject" name="id" value="{{$data->id}}" required>
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
                            <span class="sub-text">Send Email to this Staff</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($staffs as $key => $data)
            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="editStaff-{{$data->id}}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit {{$data->name}} Details</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('edit-staff')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control form-control-lg" name="id" value="{{$data->id}}" required>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Fullname</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="name" value="{{$data->name}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Username</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="username" value="{{$data->username}}" readonly required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Email</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="email" value="{{$data->email}}" readonly required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Phone Number</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="phone" value="{{$data->phone}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Role</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="role" value="{{$data->role}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                                <div class="form-group  pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Edit Staff</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Edit Staff / Lawyer Details</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($staffs as $key => $data)
            <!-- Modal Alert -->
            <div class="modal fade" tabindex="-1" id="view-{{$data->id}}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                        <div class="modal-body modal-body-lg text-center">
                            <div class="nk-modal">
                                @if($data->status ==1)
                                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                                @else
                                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-na bg-danger"></em>
                                @endif
                                <h4 class="nk-modal-title">ID: {{$data->username}}</h4>
                                <div class="nk-modal-text">
                                    <div class="caption-text"><strong>Fullname:&nbsp; &nbsp;</strong> {{$data->name}}</div>
                                    <div class="caption-text"><strong>Username:&nbsp; &nbsp;</strong> {{$data->username}}</div>
                                    <div class="caption-text"><strong>Email:&nbsp; &nbsp;</strong> {{$data->email}}</div>
                                    <div class="caption-text"><strong>Phone Number:&nbsp; &nbsp;</strong> {{$data->phone}}</div>
                                    <div class="caption-text"><strong>Role:&nbsp; &nbsp;</strong> {{$data->role}}</div>
                                    @if($data->last_login != NULL)
                                        <div class="caption-text"><strong>Last Login:</strong> {{ Carbon\Carbon::parse($data->last_time)->diffForHumans() }}</div>
                                    @else
                                        <div class="caption-text"><strong>Last Login:</strong> N/A</div>
                                    @endif
                                    @if($data->status ==1)
                                        <span class="sub-text-sm">Account <b><font color="green">Active</font></b></span>
                                    @else
                                        <span class="sub-text-sm">Account <b><font color="red">Suspended</font></b></span>
                                    @endif
                                </div>
                                <div class="nk-modal-action">
                                    <a href="#" class="btn btn-lg btn-mw btn-primary" data-dismiss="modal">OK</a>
                                </div>
                            </div>
                        </div><!-- .modal-body -->
                        <div class="modal-footer bg-lighter">
                            <div class="text-center w-100">
                                <p><a href="#">{{$data->name}}</a>'s Profile Infomation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
            
@endsection