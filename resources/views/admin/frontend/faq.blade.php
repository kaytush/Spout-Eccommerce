@extends('layouts.admindashboard')
@section('title', 'User FAQs')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="content-page">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">FAQs</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>Frequently Asked Questions</p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li><a href="#addFaq" data-toggle="modal" class="btn btn-white btn-outline-primary"><em class="icon ni ni-plus"></em><span>Add Faq</span></a></li>
                                                    </ul>
                                                </div>
                                            </div><!-- .toggle-wrap -->
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div id="faqs" class="accordion">
                                                @foreach($faqs as $key => $faq)
                                                    <div class="accordion-item">
                                                        <a href="#" class="accordion-head @if($faq->id !=1)collapsed @endif" data-toggle="collapse" data-target="#faq-q1{{$faq->id}}">
                                                            <h6 class="title">{!! $faq->title !!}</h6>
                                                            <span class="accordion-icon"></span>
                                                        </a>
                                                        <div class="accordion-body collapse @if($faq->id ==1)show @endif" id="faq-q1{{$faq->id}}" data-parent="#faqs">
                                                            <div class="accordion-inner">
                                                                <p>{!! $faq->description !!}</p>
                                                                <a href="#editFaq{{$faq->id}}" data-toggle="modal" class="btn btn-white btn-outline-primary"><em class="icon ni ni-edit"></em><span>Edit Faq</span></a>
                                                            </div>
                                                        </div>
                                                    </div><!-- .accordion-item -->
                                                @endforeach
                                                </div><!-- .accordion -->
                                            </div><!-- .card -->
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
                            </div><!-- .content-page -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="addFaq">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New FAQ</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('faqs-create')}}" enctype="multipart/form-data" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control form-control-lg" id="title" name="title" placeholder="Enter Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Description</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control form-control-sm" id="description" name="description" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="side">Side</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-control form-select" id="side" name="side" data-placeholder="Select Side" required>
                                                    <option value="1">Left</option>
                                                    <option value="2">Right</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <button type="submit" class="btn btn-lg btn-primary">Create FAQ</button>
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
                            <span class="sub-text">New FAQ</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Form End -->

            @foreach($faqs as $key => $faq)
                <!-- Modal Form -->
                <div class="modal fade" tabindex="-1" id="editFaq{{$faq->id}}">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New FAQ</h5>
                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('faqs-update', $faq->id)}}" enctype="multipart/form-data" class="form-validate is-alter">
                                    {{ csrf_field() }}
                                    <div class="row gy-4">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="title">Title</label>
                                                <input type="text" class="form-control form-control-lg" id="title" name="title" value="{{$faq->title}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="description">Description</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control form-control-sm" id="description" name="description" value="{{$faq->description}}">{{$faq->description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label" for="side">Side</label>
                                                <div class="form-control-wrap ">
                                                    <select class="form-control form-select" id="side" name="side" data-placeholder="Select Side" required>
                                                        <option selected value="{{$faq->side}}">@if($faq->side == 1) Left @elseif($faq->side == 2) Right @endif</option>
                                                        <option value="1">Left</option>
                                                        <option value="2">Right</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-lg btn-primary">Update FAQ</button>
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
                                <span class="sub-text">Edit FAQ</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Form End -->
            @endforeach

@endsection
