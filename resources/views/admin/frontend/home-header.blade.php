@extends('layouts.admindashboard')
@section('title', 'Home Header')

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
                                            <p>Homepage Header Content.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block nk-block-lg">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <form method="POST" enctype="multipart/form-data" action="" class="form-validate">
                                            {{ csrf_field() }}
                                            <div class="row g-gs">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="home_subtitle">Home Subtitle</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="home_subtitle" name="home_subtitle" value="{{$general->home_subtitle}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="home_title">Home Title</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="home_title" name="home_title" value="{{$general->home_title}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="home_button">Home Button</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="home_button" name="home_button" value="{{$general->home_button}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="home_button_link">Home button Link</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="home_button_link" name="home_button_link" value="{{$general->home_button_link}}" placeholder="https://">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <center>
                                                        @if(file_exists($general->home_image))
                                                            <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url($general->home_image)}}" width="100px" alt="">
                                                        @else
                                                            <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url('assets/images/banner-img.png')}}" width="100px" alt="">
                                                        @endif
                                                    </center>
                                                </div><!-- .col -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="logo-white">Home Header Image - <code>579x801px prefered</code></label>
                                                        <div class="form-control-wrap">
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input" name="home_image" id="customFile">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                            <code class="code-tag">Only if you want to change the Home Header Image</code>
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
