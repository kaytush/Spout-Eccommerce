@extends('layouts.admindashboard')
@section('title', 'Blog List')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Blog List</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>All Blog Posts.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt"><a href="{{ route('blog-cat') }}" class="btn btn-white btn-dim btn-outline-light"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Blog Category</span><em class="dd-indc icon ni ni-chevron-right"></em></a></li>
                                                    <li class="nk-block-tools-opt"><a href="{{ route('blog-new') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Add New Post</span></a></li>
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
                                                    <h5 class="title">Blog List</h5>
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
                                                    <div class="nk-tb-col"><span>Post Title</span></div>
                                                    <div class="nk-tb-col tb-col-xxl"><span>Date</span></div>
                                                    <div class="nk-tb-col nk-tb-col-status"><span class="sub-text d-none d-md-block">Status</span></div>
                                                    <div class="nk-tb-col nk-tb-col-tools"></div>
                                                </div><!-- .nk-tb-item -->
                                                @foreach($posts as $k=>$data)
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <div class="nk-tnx-type">
                                                                @if($data->status == 1)
                                                                    <div class="nk-tnx-type-icon bg-success-dim text-success">
                                                                        <em class="icon ni ni-arrow-up-right"></em>
                                                                    </div>
                                                                @else
                                                                    <div class="nk-tnx-type-icon bg-warning-dim text-warning">
                                                                        <em class="icon ni ni-arrow-up-right"></em>
                                                                    </div>
                                                                @endif
                                                                <div class="nk-tnx-type-text">
                                                                    <span class="tb-lead">{{ $data->title }}</span>
                                                                    <span class="tb-date">{{$data->updated_at}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-status">
                                                            @if($data->status == 1)
                                                                <div class="dot dot-success d-md-none"></div>
                                                                <span class="badge badge-sm badge-dim badge-outline-success d-none d-md-inline-flex">Published</span>
                                                            @else
                                                                <div class="dot dot-warning d-md-none"></div>
                                                                <span class="badge badge-sm badge-dim badge-outline-warning d-none d-md-inline-flex">UnPublished</span>
                                                            @endif
                                                        </div>
                                                        <div class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-2">
                                                                <li class="nk-tb-action-hidden">
                                                                    <a href="{{route('blog-edit',$data->id)}}" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="Edit Post"><em class="icon ni ni-edit"></em></a>
                                                                </li>
                                                                @if($data->status != 1)
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="{{route('activate.blog.post',$data->id)}}" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="Publish"><em class="icon ni ni-eye"></em></a>
                                                                    </li>
                                                                @else
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="{{route('deactivate.blog.post', $data->id)}}" class="bg-white btn btn-sm btn-outline-light btn-icon btn-tooltip" title="Unpublish"><em class="icon ni ni-eye-off"></em></a>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="dropdown-toggle bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <ul class="link-list-opt">
                                                                                <li><a href="{{route('blog-edit',$data->id)}}"><em class="icon ni ni-edit"></em><span>Edit Post</span></a></li>
                                                                                @if($data->status != 1)
                                                                                    <li><a href="{{route('activate.blog.post',$data->id)}}"><em class="icon ni ni-done"></em><span>Publish</span></a></li>
                                                                                @else
                                                                                    <li><a href="{{route('deactivate.blog.post', $data->id)}}"><em class="icon ni ni-eye-off"></em><span>Unpublish</span></a></li>
                                                                                @endif
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
                                        @include('pagination.default', ['paginator' => $posts])
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
@endsection
