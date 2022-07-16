@extends('layouts.adminprofile')
@section('title', 'Security Settings')

@section('profile')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

                                        <div class="card-inner card-inner-lg">
                                            <div class="nk-block-head nk-block-head-lg">
                                                <div class="nk-block-between">
                                                    <div class="nk-block-head-content">
                                                        <h4 class="nk-block-title">Security Settings</h4>
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
                                                            <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                                <div class="nk-block-text">
                                                                    <h6>Save my Activity Logs</h6>
                                                                    <p>You can save your all activity logs including unusual activity detected.</p>
                                                                </div>
                                                                <div class="nk-block-actions">
                                                                    <ul class="align-center gx-3">
                                                                        <li class="order-md-last">
                                                                            <div class="custom-control custom-switch mr-n2">
                                                                                <input type="checkbox" data-id="{{ auth()->guard('admin')->user()->id }}" name="save_log" class="custom-control-input js-switch" {{ auth()->guard('admin')->user()->save_log == 1 ? 'checked' : '' }} id="activity-log">
                                                                                <label class="custom-control-label" for="activity-log"></label>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- .card-inner -->
                                                        <div class="card-inner">
                                                            <div class="between-center flex-wrap g-3">
                                                                <div class="nk-block-text">
                                                                    <h6>Change Password</h6>
                                                                    <p>Set a unique password to protect your account.</p>
                                                                </div>
                                                                <div class="nk-block-actions flex-shrink-sm-0">
                                                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                                        <li class="order-md-last">
                                                                            <a href="#change-password" data-toggle="modal" class="btn btn-primary">Change Password</a>
                                                                        </li>
                                                                        <li>
                                                                            <em class="text-soft text-date fs-12px">Last changed: <span>@if(auth()->guard('admin')->user()->pass_changed != NULL) {{ Carbon\Carbon::parse(auth()->guard('admin')->user()->pass_changed)->diffForHumans() }} @else Never @endif</span></em>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- .card-inner -->
                                                    </div><!-- .card-inner-group -->
                                                </div><!-- .card -->
                                            </div><!-- .nk-block -->
                                        </div><!-- .card-inner -->
                                        
<script>
    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        let switchery = new Switchery(html,  { size: 'small' });
    });

    $(document).ready(function(){
        $('.js-switch').change(function () {
            let save_log = $(this).prop('checked') === true ? 1 : 0;
            let adminId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('update.activity.on.off') }}",
                data: {'save_log': save_log, 'admin_id': adminId},
                success: function (data) {
                    console.log(data.message);
                }
            });
        });
    });

    success: function (data) {
        toastr.options.closeButton = true;
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 100;
        toastr.success(data.message);
    }
</script>
@endsection
