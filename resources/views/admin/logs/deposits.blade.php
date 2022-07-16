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
                                                        <th>Trx</th>
                                                        <th>User</th>
                                                        <th>Amount</th>
                                                        <th>Fee</th>
                                                        <th>Total</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($deposits as $key => $data)
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$data->trx}}</td>
                                                            <td>{{$data->user->username}}</td>
                                                            <td>{{$gnl->currency_sym.number_format($data->amount, $gnl->decimal)}}</td>
                                                            <td>{{$gnl->currency_sym.number_format($data->fee, $gnl->decimal)}}</td>
                                                            <td>{{$gnl->currency_sym.number_format($data->total_amount, $gnl->decimal)}}</td>
                                                            <td>{!! date('d-m-Y, h:i a', strtotime($data->created_at)) !!}</td>
                                                            <td style="color:@if($data->status == 1) green @elseif($data->status == 2) blue @else red @endif">@if($data->status == 1) Paid @else Unpaid @endif</td>
                                                            <td>
                                                                <a href="{{ route('client.details', $data->user_id) }}"><span class="badge badge-pill badge-outline-primary">View User</span></a>
                                                                &nbsp;&nbsp;
                                                                <a href="#depositDetails-{{$data->id}}" data-toggle="modal"><span class="badge badge-pill badge-outline-primary">Details</span></a>
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
            @foreach ($deposits as $key => $data)
                <div class="modal fade" id="depositDetails-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="depositDetails-{{$data->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="depositDetails-{{$data->id}}">Transaction Id: {{$data->trx}}</h5>
                            </div>
                            <div class="modal-body">
                                <ul class="data-details-list">
                                    <li><div class="data-details-head">Client Name</div><div class="data-details-des">{{$data->user->firstname}} {{$data->user->lastname}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Client Username</div><div class="data-details-des"><a href="{{ route('client.details', $data->user->id) }}">{{$data->user->username}}</a></div></li><!-- li -->
                                    <li><div class="data-details-head">Amount</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->amount, $gnl->decimal)}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Fee</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->fee, $gnl->decimal)}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Total</div><div class="data-details-des">{{$gnl->currency_sym.number_format($data->total_amount, $gnl->decimal)}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Gateway</div><div class="data-details-des">{{$data->gate->name}}</div></li><!-- li -->
                                    <li><div class="data-details-head">Date</div><div class="data-details-des">{!! date('d M, Y H:i A', strtotime($data->created_at)) !!}</div></li><!-- li -->
                                    @if($data->created_at != $data->updated_at)
                                        <li><div class="data-details-head">Updated At</div><div class="data-details-des">{!! date('d M, Y H:i A', strtotime($data->updated_at)) !!}</div></li><!-- li -->
                                    @endif
                                    @if($data->status == 1)
                                        <li><div class="data-details-head">Status</div><div class="data-details-des">Paid</div></li><!-- li -->
                                    @else
                                        <li><div class="data-details-head">Status</div><div class="data-details-des">Unpaid</div></li><!-- li -->
                                    @endif
                                </ul>
                                <p></p>

                                <div class="text-center">
                                    @if($data->status == 1)
                                        <a href="javascript:void(0)"><span class="btn badge-outline-success">Paid</span></a>
                                    @else
                                        <a href="{{ route('mconfirm-flpayment', [$data->trx]) }}"><span class="btn badge-outline-primary">Approve</span></a>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

@endsection
