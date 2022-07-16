@extends('layouts.admindashboard')
@section('title', 'Service Details')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="components-preview wide-md mx-auto">
                                <div class="nk-block-head nk-block-head-lg wide-sm">
                                    <div class="nk-block-head-content">
                                        <div class="nk-block-head-sub"><a class="back-to" href="{{ route('services') }}"><em class="icon ni ni-arrow-left"></em><span>Service List</span></a></div>
                                        <h2 class="nk-block-title fw-normal">{{$service->name}} Service Details</h2>
                                    </div>
                                </div><!-- .nk-block-head -->

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <form method="POST" action="{{route('front.services.update')}}" enctype="multipart/form-data" class="form-validate">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{$service->id}}" require>
                                                <div class="row g-gs">
                                                    <div class="col-12">
                                                        <div class="form-control-wrap">
                                                            <label class="form-label" for="image">Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input" name="image" accept="image/*"  id="customFile">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="brief">Service Brief <code>(first 165 charracters only would be displayed in frontend)</code></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="brief" name="brief" value="{{$service->brief}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="details">{{$service->name}}</label>
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control form-control-sm summernote-basic" id="details" name="details">{!! $service->details !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-lg btn-primary">Save Information</button>
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
            placeholder: "{!! $service->details !!}",
            tabsize: 2,
            height: 100
        }).summernote('code', `{!! $service->details !!}`);
	</script>
@stop
