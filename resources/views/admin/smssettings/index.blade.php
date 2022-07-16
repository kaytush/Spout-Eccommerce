@extends('layouts.admindashboard')
@section('title', 'SMS Settings')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">SMS Settings</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>SMS Routes available for sending SMS.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt"><a href="{{ route('services') }}" class="btn btn-white btn-dim btn-outline-light"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Services</span><em class="dd-indc icon ni ni-chevron-right"></em></a></li>
                                                    <li class="nk-block-tools-opt"><a href="#newRoute" data-toggle="modal" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Add Route</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered card-stretch">
                                    <div class="card-inner-group">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h5 class="title">Route List</h5>
                                                </div>
                                                <div class="card-search search-wrap" data-search="search">
                                                    <div class="search-content">
                                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                                        <input type="text" class="form-control border-transparent form-focus-none" placeholder="Quick search by transaction">
                                                        <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                                    </div>
                                                </div><!-- .card-search -->
                                            </div><!-- .card-title-group -->
                                        </div><!-- .card-inner -->
                                        <div class="card-inner p-0">
                                            <div class="nk-tb-list nk-tb-tnx">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col"><span>Route Name</span></div>
                                                    <div class="nk-tb-col tb-col-xxl"><span>Source</span></div>
                                                    <div class="nk-tb-col text-lg"><span>Route API</span></div>
                                                    <div class="nk-tb-col text-right tb-col-lg"><span>Price / SMS</span></div>
                                                    <div class="nk-tb-col nk-tb-col-status"><span class="sub-text d-none d-md-block">Status</span></div>
                                                    <div class="nk-tb-col nk-tb-col-tools"></div>
                                                </div><!-- .nk-tb-item -->
                                                @foreach($smsroute as $k=>$data)
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <div class="nk-tnx-type">
                                                                @if($data->status == 1)
                                                                    <div class="nk-tnx-type-icon bg-success-dim text-success">
                                                                        <em class="icon ni ni-arrow-up-right"></em>
                                                                    </div>
                                                                @elseif($data->status == 0)
                                                                    <div class="nk-tnx-type-icon bg-warning-dim text-warning">
                                                                        <em class="icon ni ni-arrow-down-left"></em>
                                                                    </div>
                                                                @endif
                                                                <div class="nk-tnx-type-text">
                                                                    <span class="tb-lead">{{ $data->name }}</span>
                                                                    <span class="tb-date">{{$data->updated_at}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col text-lg" style="max-width: 200px;">
                                                            <span class="tb-amount">{{ $data->route }}</span>
                                                            <span class="tb-amount-lg">{{ $data->route_bal }}</span>
                                                        </div>
                                                        <div class="nk-tb-col text-right tb-col-sm">
                                                            <span class="tb-amount">{{$basic->currency_sym}}{{ $data->c_price }}<span>(Client)</span></span>
                                                            <span class="tb-amount-sm">{{$basic->currency_sym}}{{ $data->r_price }}/(Reseller)</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-status">
                                                            <div class="dot dot-success d-md-none"></div>
                                                            @if($data->status == 1)
                                                                <span class="badge badge-sm badge-dim badge-outline-success d-none d-md-inline-flex">Active</span>
                                                            @elseif($data->status == 0)
                                                                <span class="badge badge-sm badge-dim badge-outline-warning d-none d-md-inline-flex">Inactive</span>
                                                            @endif
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-2">
                                                                <li class="nk-tb-action-hidden">
                                                                    <a href="#editRoute{{$data->id}}" data-toggle="modal" class="bg-white btn btn-sm btn-outline-light btn-icon btn-tooltip" title="Edit"><em class="icon ni ni-edit"></em></a>
                                                                    <a href="{{route('delete.smsroute', $data->id)}}" class="bg-white btn btn-sm btn-outline-light btn-icon btn-tooltip" title="Delete"><em class="icon ni ni-cross-round"></em></a>
                                                                </li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="dropdown-toggle bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <ul class="link-list-opt">
                                                                                <li><a href="#editRoute{{$data->id}}" data-toggle="modal"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                                                <li><a href="{{route('delete.smsroute', $data->id)}}"><em class="icon ni ni-cross-round"></em><span>Delete</span></a></li>
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
                                        @include('pagination.default', ['paginator' => $smsroute])
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="newRoute">
                <div class="modal-dialog modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New SMS Route</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('add.smsroute')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <div class="row g-gs">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="name">Route Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name your Route">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="c_price">Client Price</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">/sms</span>
                                                </div>
                                                <input type="number" class="form-control" id="c_price" name="c_price" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="r_price">Reseller Price</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">/sms</span>
                                                </div>
                                                <input type="number" class="form-control" id="r_price" name="r_price" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="route">Route Endpoint</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                </div>
                                                <input type="text" class="form-control" id="route" name="route" placeholder="https://">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="route_bal">Route Balance Endpoint</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                </div>
                                                <input type="text" class="form-control" id="route_bal" name="route_bal" placeholder="https://">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="info">Route Info</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                </div>
                                                <input type="text" class="form-control" id="info" name="info" placeholder="short info">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="status">Status</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-control form-select" id="status" name="status" data-placeholder="Select Service" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary">Add SMS Route</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Add New SMS Route</span>
                        </div>
                    </div>
                </div>
            </div>
        @foreach($smsroute as $k=>$data)
            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="editRoute{{$data->id}}">
                <div class="modal-dialog modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit {{$data->name}} SMS Route</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('edit.smsroute')}}" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <div class="row g-gs">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="name">Route Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" placeholder="Name your Route">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="c_price">Client Price</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">/sms</span>
                                                </div>
                                                <input type="number" class="form-control" id="c_price" name="c_price" value="{{$data->c_price}}" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="r_price">Reseller Price</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">/sms</span>
                                                </div>
                                                <input type="number" class="form-control" id="r_price" name="r_price" value="{{$data->r_price}}" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="route">Route Endpoint</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                </div>
                                                <input type="text" class="form-control" id="route" name="route"value="{{$data->route}}" placeholder="https://">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="route_bal">Route Balance Endpoint</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                </div>
                                                <input type="text" class="form-control" id="route_bal" name="route_bal"value="{{$data->route_bal}}" placeholder="https://">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="info">Route Info</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                </div>
                                                <input type="text" class="form-control" id="info" name="info"value="{{$data->info}}" placeholder="short info">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="status">Status</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-control form-select" id="status" name="status"value="{{$data->status}}" data-placeholder="Select Service" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary">Update SMS Route</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Update SMS Route</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection
