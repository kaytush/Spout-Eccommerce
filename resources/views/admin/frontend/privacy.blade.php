@extends('layouts.admindashboard')
@section('title', 'Privacy Policy')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="components-preview wide-md mx-auto">
                                <div class="nk-block-head nk-block-head-lg">
                                    <div class="nk-block-head-content text-center">
                                        <h2 class="nk-block-title fw-normal">Privacy Policy</h2>
                                    </div>
                                </div><!-- .nk-block-head -->

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <form method="POST" action="{{route('home-privacy-update')}}" enctype="multipart/form-data" class="form-validate">
                                                {{ csrf_field() }}
                                                <div class="row g-gs">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="privacy">Privacy Policy Editor</label>
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control form-control-sm summernote-basic" id="privacy" name="privacy">{!! $general->privacy !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-lg btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
                            </div><!-- .components-preview -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

@endsection
@section('script')
	<script type="text/javascript">
        $('#summernote').summernote({
            placeholder: "{!!$general->privacy!!}",
            tabsize: 2,
            height: 100
        }).summernote('code', `{!!$general->privacy!!}`);
	</script>
@stop
