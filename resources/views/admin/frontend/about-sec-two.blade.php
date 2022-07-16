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
                                            <p>About Section Two.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt"><a href="{{ route('about-sec-one') }}" class="btn btn-white btn-dim btn-outline-light"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Section One</span><em class="dd-indc icon ni ni-chevron-right"></em></a></li>
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
                                                        <label class="form-label" for="sec_two_title">Section Two Title</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_title" name="sec_two_title" value="{{$about->sec_two_title}}" required>
                                                            <code class="code-tag">Enter Section Two Title</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_subtitle">Section Two Subtitle</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_subtitle" name="sec_two_subtitle" value="{{$about->sec_two_subtitle}}" required>
                                                            <code class="code-tag">Enter Section Two Subtitle</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_head">Section Two Head</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_head" name="sec_two_tab_head" value="{{$about->sec_two_tab_head}}" required>
                                                            <code class="code-tag">Enter Section Two Head</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <hr class="preview-hr">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_one">Section Two Tab One</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_one" name="sec_two_tab_one" value="{{$about->sec_two_tab_one}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_one_details">Section Two Tab One Details</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-sm" id="sec_two_tab_one_details" name="sec_two_tab_one_details" value="{{$about->sec_two_tab_one_details}}" placeholder="Enter Content Here">{{$about->sec_two_tab_one_details}}</textarea>
                                                            <code class="code-tag">HTML Tags not allowed</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_one_item_one">Section Two Tab One Item One</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_one_item_one" name="sec_two_tab_one_item_one" value="{{$about->sec_two_tab_one_item_one}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_one_item_two">Section Two Tab One Item Two</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_one_item_two" name="sec_two_tab_one_item_two" value="{{$about->sec_two_tab_one_item_two}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_one_item_three">Section Two Tab One Item Three</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_one_item_three" name="sec_two_tab_one_item_three" value="{{$about->sec_two_tab_one_item_three}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_one_button">Section Two Tab One Button</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_one_button" name="sec_two_tab_one_button" value="{{$about->sec_two_tab_one_button}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_one_button_link">Section Two Tab One Button Link</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_one_button_link" name="sec_two_tab_one_button_link" value="{{$about->sec_two_tab_one_button_link}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <hr class="preview-hr">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_two">Section Two Tab Two</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_two" name="sec_two_tab_two" value="{{$about->sec_two_tab_two}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_two_details">Section Two Tab Two Details</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-sm" id="sec_two_tab_two_details" name="sec_two_tab_two_details" value="{{$about->sec_two_tab_two_details}}" placeholder="Enter Content Here">{{$about->sec_two_tab_one_details}}</textarea>
                                                            <code class="code-tag">HTML Tags not allowed</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_two_item_one">Section Two Tab Two Item One</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_two_item_one" name="sec_two_tab_two_item_one" value="{{$about->sec_two_tab_two_item_one}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_two_item_two">Section Two Tab Two Item Two</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_two_item_two" name="sec_two_tab_two_item_two" value="{{$about->sec_two_tab_two_item_two}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_two_item_three">Section Two Tab Two Item Three</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_two_item_three" name="sec_two_tab_two_item_three" value="{{$about->sec_two_tab_two_item_three}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_two_button">Section Two Tab Two Button</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_two_button" name="sec_two_tab_two_button" value="{{$about->sec_two_tab_two_button}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_two_button_link">Section Two Tab Two Button Link</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_two_button_link" name="sec_two_tab_two_button_link" value="{{$about->sec_two_tab_two_button_link}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <hr class="preview-hr">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_three">Section Two Tab Three</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_three" name="sec_two_tab_three" value="{{$about->sec_two_tab_three}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_three_details">Section Two Tab Three Details</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-sm" id="sec_two_tab_three_details" name="sec_two_tab_three_details" value="{{$about->sec_two_tab_three_details}}" placeholder="Enter Content Here">{{$about->sec_two_tab_one_details}}</textarea>
                                                            <code class="code-tag">HTML Tags not allowed</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_three_item_one">Section Two Tab Three Item One</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_three_item_one" name="sec_two_tab_three_item_one" value="{{$about->sec_two_tab_three_item_one}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_three_item_two">Section Two Tab Three Item Two</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_three_item_two" name="sec_two_tab_three_item_two" value="{{$about->sec_two_tab_three_item_two}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_three_item_three">Section Two Tab Three Item Three</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_three_item_three" name="sec_two_tab_three_item_three" value="{{$about->sec_two_tab_three_item_three}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_three_button">Section Two Tab Three Button</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_three_button" name="sec_two_tab_three_button" value="{{$about->sec_two_tab_three_button}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_tab_three_button_link">Section Two Tab Three Button Link</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sec_two_tab_three_button_link" name="sec_two_tab_three_button_link" value="{{$about->sec_two_tab_three_button_link}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <center>
                                                        @if(file_exists($about->sec_two_image))
                                                            <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url($about->sec_two_image)}}" width="150px" alt="">
                                                        @else
                                                            <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url('assets/images/about-us.jpg')}}" width="150px" alt="">
                                                        @endif
                                                    </center>
                                                </div><!-- .col -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sec_two_image">Section Two Image - <code>550x500px prefered</code></label>
                                                        <div class="form-control-wrap">
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input" name="sec_two_image" id="customFile">
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
