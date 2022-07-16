@extends('layouts.adminprofile')
@section('title', 'Account Login Activity')

@section('profile')

                                        <div class="card-inner card-inner-lg">
                                            <div class="nk-block-head nk-block-head-lg">
                                                <div class="nk-block-between">
                                                    <div class="nk-block-head-content">
                                                        <h4 class="nk-block-title">Login Activity</h4>
                                                        <div class="nk-block-des">
                                                            <p>Here is your last 10 login activities log. <span class="text-soft"><em class="icon ni ni-info"></em></span></p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                            <div class="nk-block card card-bordered">
                                                <table class="table table-ulogs">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="tb-col-ip"><span class="overline-title">IP</span></th>
                                                            <th class="tb-col-time"><span class="overline-title">Time</span></th>
                                                            <th class="tb-col-ip"><span class="overline-title">Location</span></th>
                                                            <th class="tb-col-os"><span class="overline-title">Browser <span class="d-sm-none">/ IP</span></span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($logs as $log)
                                                        <tr>
                                                            <td class="tb-col-ip"><span class="sub-text">{{$log->admin_ip}}</span></td>
                                                            <td class="tb-col-time"><span class="sub-text">{!! date(' M d, Y H:i A', strtotime($log->created_at)) !!}</span></td>
                                                            <td class="tb-col-ip"><span class="sub-text">{{$log->location}}</span></td>
                                                            <td class="tb-col-os">{{$log->details}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div><!-- .nk-block-head -->
                                        </div><!-- .card-inner -->
@endsection
