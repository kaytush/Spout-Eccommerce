@extends('layouts.admindashboard')
@section('title', 'Services')

@section('content')

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
                                            <p>Our Services.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt"><a href="{{ route('service-cat') }}" class="btn btn-white btn-dim btn-outline-light"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Category</span><em class="dd-indc icon ni ni-chevron-right"></em></a></li>
                                                    <li class="nk-block-tools-opt"><a href="#newService" data-toggle="modal" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>New Service</span></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    @foreach($services as $key => $data)
                                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="project">
                                                        <div class="project-head">
                                                            <a href="" class="project-title">
                                                                @if($data->status ==1)
                                                                    <div class="user-avatar sq bg-purple"><span>ON</span></div>
                                                                @else
                                                                    <div class="user-avatar sq bg-danger"><span>OFF</span></div>
                                                                @endif
                                                                <div class="project-info">
                                                                    <h6 class="title">{{$data->name}}</h6>
                                                                    <span class="sub-text">{{$data->cat->name}}</span>
                                                                </div>
                                                            </a>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 mr-n1" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="{{route('front.services',$data->id)}}"><em class="icon ni ni-edit"></em><span>Frontpage Service Edit</span></a></li>
                                                                        <li><a href="#editService-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-edit"></em><span>Edit Service</span></a></li>
                                                                        @if($data->status ==0)
                                                                        <li><a href="{{route('activateservice',$data->id)}}"><em class="icon ni ni-check-round-cut"></em><span>Enable</span></a></li>
                                                                        @else
                                                                        <li><a href="{{route('deactivateservice',$data->id)}}"><em class="icon ni ni-cross-round"></em><span>Disabled</span></a></li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="project-details">
                                                            <p>{{$data->description}}</p>
                                                        </div>
                                                        <div class="project-progress">
                                                            <div class="project-progress-details">
                                                                <div class="project-progress-task"><em class="icon ni ni-check-round-cut"></em><span>{{$data->task}} @if($data->task > 1)Tasks @else Task @endif</span></div>
                                                                <div class="project-progress-percent">{{$basic->currency_sym}}{{number_format($data->price, $basic->decimal)}}</div>
                                                            </div>
                                                            <div class="progress progress-pill progress-md bg-danger">
                                                                <div class="progress-bar" data-progress="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="project-meta">
                                                            @if($data->status == 1)
                                                                <span class="badge badge-dim badge-success"><em class="icon ni ni-check"></em><span>Active</span></span>
                                                            @else
                                                                <span class="badge badge-dim badge-danger"><em class="icon ni ni-cross"></em><span>Inactive</span></span>
                                                            @endif
                                                            <span class="badge badge-dim badge-warning"><em class="icon ni ni-clock"></em><span>{{$data->duration}} @if($data->duration > 1)Days @else Day @endif</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="newService">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Service</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('create.service')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="service-name">Service Name</label>
                                            <input type="text" class="form-control form-control-lg" id="service-name" name="name" placeholder="Enter Service Name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Description</label>
                                            <input type="text" class="form-control form-control-lg" id="description" name="description" placeholder="Enter Service Description">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="cat-id">Service Category</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-control form-select" id="cat_id" name="cat_id" data-placeholder="Select Service Category" required>
                                                    <option label="empty" value=""></option>
                                                @foreach($cats as $key => $cat)
                                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price">Fee/Price</label>
                                            <input type="number" class="form-control form-control-lg" id="price" name="price" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price_tag">Price Tag Word</label>
                                            <input type="text" class="form-control form-control-lg" id="price_tag" name="price_tag" placeholder="Enter Fee Tag">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="task">Tasks</label>
                                            <input type="number" class="form-control form-control-lg" id="task" name="task" placeholder="Enter number of Tasks">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="duration">Duration (Expected delivery Time Frame)</label>
                                            <input type="number" class="form-control form-control-lg" id="duration" name="duration" placeholder="Enter Duration in Days">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Create Service</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">New Offered Service</span>
                        </div>
                    </div>
                </div>
            </div>

        @foreach($services as $key => $data)
            <!-- Edit Service Modal Form -->
            <div class="modal fade" tabindex="-1" id="editService-{{$data->id}}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Service</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('update.service')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{$data->id}}" name="id">
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="service-name">Service Name</label>
                                            <input type="text" class="form-control form-control-lg" id="service-name" name="name" value="{{$data->name}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Description</label>
                                            <input type="text" class="form-control form-control-lg" id="description" name="description" value="{{$data->description}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="cat-id">Service Category</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-control form-select" id="cat-id" name="cat_id" data-placeholder="Select Service Category" required>
                                                    <option value="{{$data->cat_id}}">{{$data->cat->name}}</option>
                                                @foreach($cats as $key => $cat)
                                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price">Fee/Price</label>
                                            <input type="number" class="form-control form-control-lg" id="price" name="price" value="{{$data->price}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price_tag">Price Tag Word</label>
                                            <input type="text" class="form-control form-control-lg" id="price_tag" name="price_tag" value="{{$data->price_tag}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="task">Tasks</label>
                                            <input type="number" class="form-control form-control-lg" id="task" name="task" value="{{$data->task}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="duration">Duration (Expected delivery Time Frame)</label>
                                            <input type="number" class="form-control form-control-lg" id="duration" name="duration" value="{{$data->duration}}">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Update Service</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Edit Offered Service</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection
