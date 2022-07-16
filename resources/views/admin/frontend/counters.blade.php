@extends('layouts.admindashboard')
@section('title', 'Counters')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Counters</h3>
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
                                                    <div class="nk-tb-col"><span class="sub-text">Title</span></div>
                                                    <div class="nk-tb-col tb-col-mb"><span class="sub-text">Value</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span class="sub-text">Sub Value</span></div>
                                                    <div class="nk-tb-col nk-tb-col-tools text-right"></div>
                                                </div><!-- .nk-tb-item -->
                                                @foreach($counters as $key => $data)
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
                                                                    <img src="{{url('assets/images/svg')}}/{{$data->icon}}" alt="">
                                                                </div>
                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{$data->title}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                                    <span>{{$data->updated_at}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-mb">
                                                            <span class="tb-amount">{{$data->value}}</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-lg">
                                                            <span>{{$data->subvalue}}</span>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <li>
                                                                    <div class="">
                                                                        <a href="#editCounter-{{$data->id}}" data-toggle="modal" class="btn btn-icon btn-trigger"><em class="icon ni ni-edit"></em></a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div><!-- .nk-tb-item -->
                                                @endforeach
                                            </div><!-- .nk-tb-list -->
                                        </div><!-- .card-inner -->
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

        @foreach($counters as $key => $data)
            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="editCounter-{{$data->id}}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit {{$data->name}} Details</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('edit-counter')}}" enctype="multipart/form-data" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control form-control-lg" name="id" value="{{$data->id}}" required>
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Title</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="title" value="{{$data->title}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Value</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="number" class="form-control form-control-lg" name="value" value="{{$data->value}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Sub Value</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="subvalue" value="{{$data->subvalue}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <center>
                                            <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url('assets/images/svg')}}/{{$data->icon}}" width="100px" alt="">
                                        </center>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">SVG <span class="text-danger">(Change SVG Icon)</span></label>
                                            </div>
                                            <div class="form-control-group custom-file">
                                                <input type="file" multiple class="custom-file-input" name="icon" accept="svg/*"  id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                                <div class="form-group  pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Edit Counter</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Counter Editor</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection
