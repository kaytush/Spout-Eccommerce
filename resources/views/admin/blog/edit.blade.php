@extends('layouts.admindashboard')
@section('title', 'Edit Blog Post')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="components-preview wide-md mx-auto">
                                <div class="nk-block-head nk-block-head-lg wide-sm">
                                    <div class="nk-block-head-content">
                                        <div class="nk-block-head-sub"><a class="back-to" href="{{ route('blog-list') }}"><em class="icon ni ni-arrow-left"></em><span>Blog List</span></a></div>
                                        <h2 class="nk-block-title fw-normal">Edit Blog Post</h2>
                                    </div>
                                </div><!-- .nk-block-head -->

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <form method="POST" action="{{route('edit-post')}}" enctype="multipart/form-data" class="form-validate">
                                                {{ csrf_field() }}
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{$blogpost->id}}">
                                                <div class="row g-gs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="title">Post Title</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="title" name="title" value="{{$blogpost->title}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="cat_id">Blog Category</label>
                                                            <div class="form-control-wrap ">
                                                                <select class="form-control form-select" id="cat_id" name="cat_id" data-placeholder="Select Blog Category" required>
                                                                    <option value="{{$blogpost->cat_id}}">{{$blogpost->blogcat->name}}</option>
                                                                    @foreach ($cats as $data)
                                                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-control-wrap">
                                                            {{-- <label class="form-label" for="image">Featured Image</label> --}}
                                                            @if( file_exists($blogpost->image))
                                                                <center>
                                                                    <img src="{{asset($blogpost->image)}}" width="50%" alt="{{$blogpost->title}}"/>
                                                                </center>
                                                            @else
                                                                <center>
                                                                    <p>No Image Set</p>
                                                                </center>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-control-wrap">
                                                            <label class="form-label" for="image">Featured Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input" name="image" accept="image/*"  id="customFile">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="details">Edit Content</label>
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control form-control-sm summernote-basic" id="details" name="details">{!!$blogpost->details!!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="status">Status</label>
                                                            <div class="form-control-wrap ">
                                                                <select class="form-control form-select" id="status" name="status" required>
                                                                    <option value="{{$blogpost->status}}">@if($blogpost->status ==1) Publish @elseif($blogpost->status == 0) Unpublish(Draft) @endif</option>
                                                                    <option value="1">Publish</option>
                                                                    <option value="0">Unpublish(Draft)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-lg btn-primary">Update Post</button>
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
            placeholder: "{!!$blogpost->details!!}",
            tabsize: 2,
            height: 100
        }).summernote('code', `{!!$blogpost->details!!}`);
	</script>
@stop
