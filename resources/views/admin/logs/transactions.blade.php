@extends('layouts.admindashboard')
@section('title', $page_title)

@section('content')
@include('layouts.css')
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="components-preview">
                                <div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
                                    <div class="nk-block-head-content text-center">
                                        <h2 class="nk-block-title fw-normal">@yield('title')</h2>
                                    </div>
                                </div><!-- .nk-block-head -->

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
                                            <table class="datatable-init table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($transactions as $key => $data)
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$data->user->username}}</td>
                                                            <td>{{$data->title}}</td>
                                                            <td>{{$data->description}}</td>
                                                            <td>{{$gnl->currency_sym.number_format($data->amount, $gnl->decimal)}}</td>
                                                            <td>{!! date('d-m-Y, h:i a', strtotime($data->created_at)) !!}</td>
                                                            <td>
                                                                <a href="{{ route('client.details', $data->user_id) }}"><span class="badge badge-pill badge-outline-primary">View User</span></a>
                                                                &nbsp;&nbsp;
                                                                <a href="#trxDetails-{{$data->id}}" data-toggle="modal"><span class="badge badge-pill badge-outline-primary">Details</span></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- .card-preview -->
                                </div> <!-- nk-block -->
                            </div><!-- .components-preview -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

            <!-- Modal -->
            @foreach ($transactions as $key => $data)
                <div class="modal fade" id="trxDetails-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="trxDetails-{{$data->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="trxDetails-{{$data->id}}">Transaction Id: {{$data->trx}}</h5>
                            </div>
                            <div class="modal-body">
                                <ul class="data-details-list">
                                    <li><div class="data-details-head">Client Name</div><div class="data-details-des">{{$data->user->firstname}} {{$data->user->lastname}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Client Username</div><div class="data-details-des"><a href="{{ route('client.details', $data->user->id) }}">{{$data->user->username}}</a></div></li><!-- li -->
                                    <li><div class="data-details-head">Title</div><div class="data-details-des">{{$data->title}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Description</div><div class="data-details-des">{{$data->description}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Service</div><div class="data-details-des">{{$data->service}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Type</div><div class="data-details-des">@if($data->type == 1) <font color="green">Credit</font> @else <font color="red">Debit</font> @endif</div></li><!-- li -->
                                    <li><div class="data-details-head">Amount</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->amount, $gnl->decimal)}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Trx</div><div class="data-details-des">{{$data->trx}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Date</div><div class="data-details-des">{!! date('d M, Y H:i A', strtotime($data->created_at)) !!}</div></li><!-- li -->
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

@endsection
