@extends('layouts.admindashboard')
@section('title', $page_title)

@section('content')

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
                                                        <th>Miner</th>
                                                        <th>Amount</th>
                                                        <th>Fee</th>
                                                        <th>Total</th>
                                                        <th>Date</th>
                                                        @if ($page_title == "All Payouts")
                                                            <th>Status</th>
                                                        @endif
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payouts as $key => $data)
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{$data->trx}}</td>
                                                            <td>{{$data->user->tron_address}}</td>
                                                            <td>{{$data->amount}}</td>
                                                            <td>{{$data->fee}}</td>
                                                            <td>{{$data->total}}</td>
                                                            <td>{!! date('d-m-Y, h:i a', strtotime($data->created_at)) !!}</td>
                                                            @if ($page_title == "All Payouts")
                                                                <td style="color:@if($data->status == "Success") green @elseif($data->status == "Processing") orange @elseif($data->status == "Pending") blue @else red @endif">{{$data->status}}</td>
                                                            @endif
                                                            <td>
                                                                <a href="{{ route('client.details', $data->user_id) }}"><span class="badge badge-pill badge-outline-primary">View Miner</span></a>
                                                                &nbsp;&nbsp;
                                                                <a href="#payoutDetails-{{$data->id}}" data-toggle="modal"><span class="badge badge-pill badge-outline-primary">Process</span></a>
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
            @foreach ($payouts as $key => $data)
                <div class="modal fade" id="payoutDetails-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="payoutDetails-{{$data->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="payoutDetails-{{$data->id}}">Transaction Id: {{$data->trx}}</h5>
                            </div>
                            <div class="modal-body text-center">
                                <p>Miner<br><a href="{{ route('client.details', $data->user->id) }}" target="_blank">{{$data->user->tron_address}}</a></p>
                                <p>Payout Amount: {{$gnl->currency_sym.$data->amount}}</p>
                                <p>Fee: {{$gnl->currency_sym.$data->fee}}</p>
                                <p>Total Charged: {{$gnl->currency_sym.$data->total}}</p>
                                <p>Request Date: {!! date('d-m-Y, h:i a', strtotime($data->created_at)) !!}</p>
                                @if($data->created_at != $data->updated_at)
                                    <p>Updated At: {!! date('d-m-Y, h:i a', strtotime($data->updated_at)) !!}</p>
                                @endif
                                <div>
                                    @if($data->confirmed_by != NULL)
                                        <p>Confirmed By: <b>{{$data->confirmed_by}}</b></p>
                                    @endif
                                    @if($data->status != "Success")
                                        <a href="{{ route('confirm.payout', $data->id) }}"><span class="btn badge-outline-primary">Confirm payout</span></a>
                                        <a href="{{ route('processing.payout', $data->id) }}"><span class="btn badge-outline-info">Processing payout</span></a>
                                    @else
                                        <a href="javascript:void(0)"><span class="btn badge-outline-success">Paid</span></a>
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
