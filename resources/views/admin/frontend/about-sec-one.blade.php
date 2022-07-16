@extends('layouts.admindashboard')
@section('title', 'About Section')

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
                                            <p>About Section One.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt"><a href="{{ route('about-sec-two') }}" class="btn btn-white btn-dim btn-outline-light"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Section Two</span><em class="dd-indc icon ni ni-chevron-right"></em></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block nk-block-lg">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <form method="POST" enctype="multipart/form-data" action="" class="form-validate">
                                            {{ csrf_field() }}
                                            <div class="row g-gs">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_subtitle">Section One Subtitle</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_one_subtitle" name="sec_one_subtitle" value="{{$about->sec_one_subtitle}}" required>
                                                            <code class="code-tag">Enter Section One Subtitle</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_title">Section One Title</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_one_title" name="sec_one_title" value="{{$about->sec_one_title}}" required>
                                                            <code class="code-tag">Enter Section One Title</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_details">Section One Details</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-sm" id="sec_one_details" name="sec_one_details" value="{{$about->sec_one_details}}" placeholder="Enter Content Here">{{$about->sec_one_details}}</textarea>
                                                            <code class="code-tag">HTML Tags not allowed</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_itemone">Section One Item One</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_one_itemone" name="sec_one_itemone" value="{{$about->sec_one_itemone}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_itemtwo">Section One Item Two</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_one_itemtwo" name="sec_one_itemtwo" value="{{$about->sec_one_itemtwo}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_itemthree">Section One Item Three</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_one_itemthree" name="sec_one_itemthree" value="{{$about->sec_one_itemthree}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_itemfour">Section One Item Four</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_one_itemfour" name="sec_one_itemfour" value="{{$about->sec_one_itemfour}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_button">Section One Action Button</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_one_button" name="sec_one_button" value="{{$about->sec_one_button}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_button_link">Section One Action Button Link</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_one_button_link" name="sec_one_button_link" value="{{$about->sec_one_button_link}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <center>
                                                        @if(file_exists($about->sec_one_image))
                                                            <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url($about->sec_one_image)}}" width="150px" alt="">
                                                        @else
                                                            <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url('assets/images/about-us.jpg')}}" width="150px" alt="">
                                                        @endif
                                                    </center>
                                                </div><!-- .col -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_one_image">Section One Image - <code>550x500px prefered</code></label>
                                                        <div class="form-control-wrap">
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input" name="sec_one_image" id="customFile">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                            <code class="code-tag">Only if you want to change your Section Image</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lg btn-primary">Save Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
@endsection
