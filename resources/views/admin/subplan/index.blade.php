@extends('layouts.admindashboard')
@section('title', 'Subscription Plans')

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
                                            <p>Subscription Packages.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt"><a href="{{ route('services') }}" class="btn btn-white btn-dim btn-outline-light"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Services</span></a></li>
                                                    <li class="nk-block-tools-opt"><a href="#newService" data-toggle="modal" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Add Plan</span></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                                                        <div class="nk-block">
                                <form action="" class="plan-iv">
                                    <div class="plan-iv-list nk-slider nk-slider-s2">
                                        <ul class="plan-list slider-init" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite":false, "responsive":[
                                                {"breakpoint": 992,"settings":{"slidesToShow": 2}},
                                                {"breakpoint": 768,"settings":{"slidesToShow": 1}}
                                            ]}'>
                                            @foreach($subplans as $key => $data)
                                                <li class="plan-item">
                                                    <input type="radio" id="plan-iv-{{$data->id}}" name="plan" value="{{$data->id}}" class="plan-control">
                                                    <div class="plan-item-card">
                                                        <div class="plan-item-head">
                                                            <div class="plan-item-heading">
                                                                <h4 class="plan-item-title card-title title">{{$data->name}}</h4>
                                                                <p class="sub-text">{{$data->info}}</p>
                                                            </div>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 mr-n1" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        @if($data->status ==0)
                                                                        <li><a href="{{route('activatesubplan',$data->id)}}"><em class="icon ni ni-eye"></em><span>Enable</span></a></li>
                                                                        @else
                                                                        <li><a href="{{route('deactivatesubplan',$data->id)}}"><em class="icon ni ni-eye-off"></em><span>Disable</span></a></li>
                                                                        @endif
                                                                        <li><a href="#edit-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-edit"></em><span>Edit Plan</span></a></li>
                                                                        <li><a href="{{route('subplan.delete',$data->id)}}"><em class="icon ni ni-trash"></em><span>Delete Plan</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="plan-item-summary card-text">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        {{-- <span class="lead-text">Status</span> --}}
                                                                        @if($data->status ==1)
                                                                            <span class="badge badge-pill badge-success">Enabaled</span>
                                                                        @else
                                                                            <span class="badge badge-pill badge-warning">Disabled</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-6">
                                                                        {{-- <span class="lead-text">LU</span> --}}
                                                                        <span class="sub-text"> {{ Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="plan-item-body">
                                                            <div class="plan-item-desc card-text">
                                                                <ul class="plan-item-desc-list">
                                                                    <li><span class="desc-label">Monthly</span> - <span class="desc-data">{{$basic->currency_sym}}{{number_format($data->mprice, $basic->decimal)}}</span></li>
                                                                    <li><span class="desc-label">Quarterly</span> - <span class="desc-data">{{$basic->currency_sym}}{{number_format($data->qprice, $basic->decimal)}}</span></li>
                                                                    <li><span class="desc-label">Semi-Annual</span> - <span class="desc-data">{{$basic->currency_sym}}{{number_format($data->sprice, $basic->decimal)}}</span></li>
                                                                    <li><span class="desc-label">Annually</span> - <span class="desc-data">{{$basic->currency_sym}}{{number_format($data->aprice, $basic->decimal)}}</span></li>
                                                                </ul>
                                                                <div class="plan-item-action">
                                                                    <label for="plan-iv-{{$data->id}}" class="plan-label">
                                                                        <a href="#edit-{{$data->id}}" data-toggle="modal" class="plan-label-base">Select to edit</a>
                                                                        <a href="#edit-{{$data->id}}" data-toggle="modal" class="plan-label-selected">Edit Now</a>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li><!-- .plan-item -->
                                            @endforeach
                                        </ul><!-- .plan-list -->
                                    </div>
                                </form>
                            </div><!-- nk-block -->
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
                            <h5 class="modal-title">Add New Package</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('create.subplan')}}" enctype="multipart/form-data" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="name">Plan Name</label>
                                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter Package Name" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="info">Short Info</label>
                                            <input type="text" class="form-control form-control-lg" id="info" name="info" placeholder="Enter package short info" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="mprice">Monthly Price</label>
                                            <input type="number" class="form-control form-control-lg" id="mprice" name="mprice" value="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="qprice">Quarterly Price</label>
                                            <input type="number" class="form-control form-control-lg" id="qprice" name="qprice" value="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="sprice">Semi-Annual Price</label>
                                            <input type="number" class="form-control form-control-lg" id="sprice" name="sprice" value="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="aprice">Annually Price</label>
                                            <input type="number" class="form-control form-control-lg" id="aprice" name="aprice" value="0" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="latest-sale" name="status">
                                            <label class="custom-control-label" for="latest-sale">Status (Enable or Disable) </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <button type="submit" class="btn btn-lg btn-primary">Create Package</button>
                                            </li>
                                            <li>
                                                <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">New Subscription Package</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Form End -->

            @foreach($subplans as $key => $data)
                <!-- Edit Modal Form -->
                <div class="modal fade" tabindex="-1" id="edit-{{$data->id}}">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update {{$data->name}} Package</h5>
                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('post.subplan')}}" enctype="multipart/form-data" class="form-validate is-alter">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-control form-control-lg" id="id" name="id" value="{{$data->id}}">
                                    <div class="row gy-4">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Plan Name</label>
                                                <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{$data->name}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="info">Short Info</label>
                                                <input type="text" class="form-control form-control-lg" id="info" name="info" value="{{$data->info}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="mprice">Monthly Price</label>
                                                <input type="number" class="form-control form-control-lg" id="mprice" name="mprice" value="{{$data->mprice}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="qprice">Quarterly Price</label>
                                                <input type="number" class="form-control form-control-lg" id="qprice" name="qprice" value="{{$data->qprice}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="sprice">Semi-Annual Price</label>
                                                <input type="number" class="form-control form-control-lg" id="sprice" name="sprice" value="{{$data->sprice}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="aprice">Annually Price</label>
                                                <input type="number" class="form-control form-control-lg" id="aprice" name="aprice" value="{{$data->aprice}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="status-edit-{{$data->id}}" name="status" {{ $data->status == "1" ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status-edit-{{$data->id}}">Status (Enable or Disable) </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-lg btn-primary">Update Package</button>
                                                </li>
                                                <li>
                                                    <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer bg-light">
                                <span class="sub-text">Subscription Package Edit</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Form End -->
            @endforeach
@endsection