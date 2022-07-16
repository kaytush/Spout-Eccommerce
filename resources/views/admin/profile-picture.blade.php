@extends('layouts.adminprofile')
@section('title', 'Update Profile Picture')

@section('profile')

                                        <div class="card-inner card-inner-lg">
                                            <div class="nk-block-head nk-block-head-lg">
                                                <div class="nk-block-between">
                                                    <div class="nk-block-head-content">
                                                        <h4 class="nk-block-title">Update Profile Picture</h4>
                                                        <div class="nk-block-des">
                                                            <p>These settings are helps you keep your account secure.</p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                            <div class="nk-block">
                                                <div class="card card-bordered">
                                                    <div class="card-inner-group">
                                                        <div class="card-inner">
                                                            <div class="between-center flex-wrap g-3">
                                                                <div class="nk-block-text">
                                                                    <h6>Profile Picture</h6>
                                                                    <p>Select a media file to update your profile picture.</p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <form action="{{route('profile-image')}}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="form-control-wrap">
                                                                    <div class="custom-file">
                                                                        <input type="file" multiple class="custom-file-input" name="image" accept="image/*"  id="customFile">
                                                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <button class="btn btn-round btn-primary" type="submit">Update Picture</button>
                                                            </form>
                                                        </div><!-- .card-inner -->
                                                    </div><!-- .card-inner-group -->
                                                </div><!-- .card -->
                                            </div><!-- .nk-block -->
                                        </div><!-- .card-inner -->
@endsection
