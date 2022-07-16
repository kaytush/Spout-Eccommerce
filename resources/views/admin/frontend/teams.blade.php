@extends('layouts.admindashboard')
@section('title', 'Teams')

@section('content')

            @php
                $all = \App\Models\Team::count();
            @endphp
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Team List</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>You have total <b>{{$all}}</b> Team Members.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    {{-- <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li> --}}
                                                    <li><a href="#addTeam" data-toggle="modal" class="btn btn-white btn-outline-primary"><em class="icon ni ni-plus"></em><span>Add Team</span></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    @foreach($teams as $key => $data)
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
                                                                        <li><a href="#editTeam-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-edit"></em><span>Edit Team</span></a></li>
                                                                        <li class="divider"></li>
                                                                        @if($data->status ==0)
                                                                            <li><a href="{{ route('activate.team', $data->id) }}"><em class="icon ni ni-check-circle"></em><span>Enable Member</span></a></li>
                                                                        @else
                                                                            <li><a href="{{ route('deactivate.team', $data->id) }}"><em class="icon ni ni-na"></em><span>Disable Member</span></a></li>
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
                                                                    <img src="{{url('assets/images/team/team.png')}}" alt="">
                                                                @endif
                                                            </div>
                                                            <div class="user-info">
                                                                <h6>{{$data->name}}</h6>
                                                                <span class="sub-text">{{$data->role}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="team-view">
                                                            <a href="#editTeam-{{$data->id}}" data-toggle="modal" class="btn btn-round btn-outline-light w-150px"><span>Edit Team</span></a>
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
            <div class="modal fade" tabindex="-1" id="addTeam">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Team Member</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('create-team')}}" enctype="multipart/form-data" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Fullname <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="email" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="phone" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Image <span class="text-danger">(Optional) - <code>270x300px prefered</code></span></label>
                                            </div>
                                            <div class="form-control-group custom-file">
                                                <input type="file" multiple class="custom-file-input" name="image" accept="image/*"  id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="role" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">facebook url</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="facebook" placeholder="https://">
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">twitter url</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="twitter" placeholder="https://">
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">instagram url</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="instagram" placeholder="https://">
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">linkedin url</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="linkedin" placeholder="https://">
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                                <div class="form-group  pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Add Team Member</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Add New Team Member</span>
                        </div>
                    </div>
                </div>
            </div>

        @foreach($teams as $key => $data)
            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="editTeam-{{$data->id}}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit {{$data->name}} Details</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('edit-team')}}" enctype="multipart/form-data" class="form-validate is-alter">
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
                                                <label class="form-label">Email</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="email" value="{{$data->email}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Phone Number</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="phone" value="{{$data->phone}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Role</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="role" value="{{$data->role}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <center>
                                            <div class="user-avatar lg bg-primary">
                                                @if(file_exists($data->image))
                                                    <img src="{{url($data->image)}}" alt="">
                                                @else
                                                    <img src="{{url('assets/images/team/team.png')}}" alt="">
                                                @endif
                                            </div>
                                        </center>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Image <span class="text-danger">(Change Image) - <code>270x300px prefered</code></span></label>
                                            </div>
                                            <div class="form-control-group custom-file">
                                                <input type="file" multiple class="custom-file-input" name="image" accept="image/*"  id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">facebook url</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="facebook" value="{{$data->facebook}}">
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">twitter url</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="twitter" value="{{$data->twitter}}">
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">instagram url</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="instagram" value="{{$data->instagram}}">
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">linkedin url</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="linkedin" value="{{$data->linkedin}}">
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                                <div class="form-group  pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Edit Team Member</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Edit Team Member</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

@endsection
