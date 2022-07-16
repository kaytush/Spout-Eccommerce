@extends('layouts.admindashboard')
@section('title', $page_title)

@section('content')

            <!-- content @s -->
                <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-xl">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head">
                                    <div class="nk-block-between g-3">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Invoices</h3>
                                            <div class="nk-block-des text-soft"><p>You have a total of <b>{{App\Models\Invoice::count()}}</b> invoice(s).</p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block">
                                    <div class="card card-bordered card-stretch">
                                        <div class="card-inner-group">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title"><h5 class="title">@yield('title')</h5></div>
                                                </div>
                                            </div>
                                            <div class="card-inner p-0">
                                                <table class="table table-orders">
                                                    <thead class="tb-odr-head">
                                                        <tr class="tb-odr-item">
                                                            <th class="tb-odr-info"><span class="tb-odr-id">Trx ID</span><span class="tb-odr-date d-none d-md-inline-block">Date</span></th>
                                                            <th class="tb-odr-amount"><span class="tb-odr-total">Amount</span><span class="tb-odr-status d-none d-md-inline-block">Status</span></th>
                                                            <th class="tb-odr-action">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tb-odr-body">
                                                        @foreach($invoices as $key => $data)
                                                            <tr class="tb-odr-item">
                                                                <td class="tb-odr-info">
                                                                    <span class="tb-odr-id"><a href="{{ route('invoice.details', $data->trx) }}">{{$data->trx}}</a></span><span class="tb-odr-date">{!! date('d M Y, H:i a', strtotime($data->updated_at)) !!}</span>
                                                                </td>
                                                                <td class="tb-odr-amount">
                                                                    <span class="tb-odr-total"><span class="amount">{{$general->currency_sym}}{{number_format($data->total, $general->decimal)}}</span></span><span class="tb-odr-status">
                                                                        @if($data->status ==1)
                                                                            <span class="badge badge-dot badge-success">Paid</span>
                                                                        @elseif($data->status ==2)
                                                                            <span class="badge badge-dot badge-primary">Pending Confirmation</span>
                                                                        @else
                                                                            <span class="badge badge-dot badge-warning">Unpaid</span>
                                                                        @endif
                                                                    </span>
                                                                </td>
                                                                <td class="tb-odr-action">
                                                                    <div class="tb-odr-btns d-none d-sm-inline">
                                                                        <a href="{{ route('invoice.print', $data->trx) }}" target="_blank" class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em class="icon ni ni-printer-fill"></em></a>
                                                                        <a href="{{ route('invoice.details', $data->trx) }}" class="btn btn-dim btn-sm btn-primary">View</a>
                                                                    </div>
                                                                    <a href="{{ route('invoice.details', $data->trx) }}" class="btn btn-pd-auto d-sm-none"><em class="icon ni ni-chevron-right"></em></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @include('pagination.default', ['paginator' => $invoices])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- content @e -->

@endsection
