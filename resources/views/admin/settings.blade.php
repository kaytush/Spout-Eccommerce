@extends('layouts.admindashboard')
@section('title', 'General System Settings')

@section('content')

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">@yield('title')</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>System general Settings & Configuration.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt"><a href="{{ route('services') }}" class="btn btn-white btn-dim btn-outline-light"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Subscrition</span><em class="dd-indc icon ni ni-chevron-right"></em></a></li>
                                                    <li class="nk-block-tools-opt"><a href="{{ route('services') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Services</span></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block nk-block-lg">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <form method="POST" enctype="multipart/form-data" action="" class="form-validate">
                                            {{ csrf_field() }}
                                            <div class="row g-gs">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sitename">Website Name</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="sitename" name="sitename" value="{{$general->sitename}}" required>
                                                            <code class="code-tag">Enter your Website Name</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="currency">System Currency</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="currency" name="currency" value="{{$general->currency}}" required>
                                                            <code class="code-tag">Enter the System Base Currency</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="currency_sym">Currency Symbol</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="currency_sym" name="currency_sym" value="{{$general->currency_sym}}" required>
                                                            <code class="code-tag">Input the Currency Symbol</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="decimal">Currency Decimal</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" class="form-control" id="decimal" name="decimal" value="{{$general->decimal}}" required>
                                                            <code class="code-tag">Currency Decimal Place. Must be digit e.g 2 (2 means .00)</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="email">Website Email</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="email" name="email" value="{{$general->email}}" required>
                                                            <code class="code-tag">System Email Address</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="phone">Website Phone Number</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="phone" name="phone" value="{{$general->phone}}" required>
                                                            <code class="code-tag">System Phone Number</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address">Office Address</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="address" name="address" value="{{$general->address}}" required>
                                                            <code class="code-tag">System Office Address</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address2">Office Address 2</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="address2" name="address2" value="{{$general->address2}}">
                                                            <code class="code-tag">System Office Address 2</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address3">Office Address 3</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="address3" name="address3" value="{{$general->address3}}">
                                                            <code class="code-tag">System Office Address 3</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address">Map Iframe</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="map" name="map" value="{{$general->map}}" required>
                                                            <code class="code-tag">Address Map Iframe</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="description">Website Description</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="description" name="description" value="{{$general->description}}" required>
                                                            <code class="code-tag">Enter the website description</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="facebook">Facebook Page</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="facebook" name="facebook" value="{{$general->facebook}}" placeholder="https://facebook.com/cmb">
                                                            <code class="code-tag">provide the full URL to the Facebook Page includding http://</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="twitter">Twitter Handle</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="twitter" name="twitter" value="{{$general->twitter}}" placeholder="https://twitter.com/cmb">
                                                            <code class="code-tag">provide the full URL to the Twitter Handle includding http://</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="instagram">Instagram Page</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="instagram" name="instagram" value="{{$general->instagram}}" placeholder="https://instagram.com/cmb">
                                                            <code class="code-tag">provide the full URL to the Instagram Handle includding http://</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="linkedin">LinkedIn</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{$general->linkedin}}" placeholder="https://linkedin.com/cmb">
                                                            <code class="code-tag">provide the full URL to the LinkedIn includding http://</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="telegram">Telegram</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="telegram" name="telegram" value="{{$general->telegram}}" placeholder="https://telegram.com/cmb">
                                                            <code class="code-tag">provide the full URL to the Telegram includding http://</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="youtube">YouTube</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="youtube" name="youtube" value="{{$general->youtube}}" placeholder="https://youtube.com/cmb">
                                                            <code class="code-tag">provide the full URL to the YouTube includding http://</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="vat">Transaction Charge (VAT)</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" class="form-control" id="vat" name="vat" value="{{$general->vat}}" required>
                                                            <code class="code-tag">Tax % on all Payments/Invoices</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="stampduty">Stamp Duty</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="stampduty" name="stampduty" value="{{$general->stampduty}}" required>
                                                            <code class="code-tag">Fixed amount charged on manual transaction</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="addfee_name">Additional Charge</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="addfee_name" name="addfee_name" value="{{$general->addfee_name}}">
                                                            <code class="code-tag">Name of the Additional charge amount</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="addfee_amount">Additional Charge Amount</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="addfee_amount" name="addfee_amount" value="{{$general->addfee_amount}}">
                                                            <code class="code-tag">Additional charge amount on all payment. (Fixed Amount)</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="logo">Website Logo</label>
                                                        <div class="form-control-wrap">
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input" name="logo" id="customFile">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                            <code class="code-tag">Only if you want to change your logo</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="favicon">Website Favicon</label>
                                                        <div class="form-control-wrap">
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input" name="favicon" id="customFile">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                            <code class="code-tag">Only if you want to change your favicon</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="logo-white">Website Footer Logo</label>
                                                        <div class="form-control-wrap">
                                                            <div class="custom-file">
                                                                <input type="file" multiple class="custom-file-input" name="logo_white" id="customFile">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                            <code class="code-tag">Only if you want to change the white version of your logo</code>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="livechat">Live Chat Script Code</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-sm" id="livechat" name="livechat" value="{{$general->livechat}}" placeholder="<script></script>">{{$general->livechat}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lg btn-primary">Save Settings</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- .nk-block -->
                            <div class="nk-block nk-block-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="title nk-block-title">Other Setting</h4>
                                        <div class="nk-block-des">
                                            <p>System Control Management Settings.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-head">
                                            <h5 class="card-title">Configuration Settings</h5>
                                        </div>
                                        <form action="{{ route('UpdateOtherSettings') }}" method="POST" enctype="multipart/form-data" class="gy-3">
                                            {{ csrf_field() }}
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label class="form-label">Allow Registration</label>
                                                        <span class="form-note">Enable or disable registration on website.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <ul class="custom-control-group g-3 align-center flex-wrap">
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="1" name="registration" {{$general->registration == "1" ? 'checked' : '' }} id="registration-enable">
                                                                <label class="custom-control-label" for="registration-enable">Enable</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="0" name="registration" {{$general->registration == "0" ? 'checked' : '' }} id="registration-disable">
                                                                <label class="custom-control-label" for="registration-disable">Disable</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label class="form-label">Allow Login</label>
                                                        <span class="form-note">Enable or disable login on website.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <ul class="custom-control-group g-3 align-center flex-wrap">
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="1" name="login" {{$general->login == "1" ? 'checked' : '' }} id="login-enable">
                                                                <label class="custom-control-label" for="login-enable">Enable</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="0" name="login" {{$general->login == "0" ? 'checked' : '' }} id="login-disable">
                                                                <label class="custom-control-label" for="login-disable">Disable</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label class="form-label">Email Verification</label>
                                                        <span class="form-note">Enable or disable email Verification on website.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <ul class="custom-control-group g-3 align-center flex-wrap">
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="1" name="email_verification" {{$general->email_verification == "1" ? 'checked' : '' }} id="emailver-enable">
                                                                <label class="custom-control-label" for="emailver-enable">Enable</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="0" name="email_verification" {{$general->email_verification == "0" ? 'checked' : '' }} id="emailver-disable">
                                                                <label class="custom-control-label" for="emailver-disable">Disable</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label class="form-label">Email Notification</label>
                                                        <span class="form-note">Enable or disable email Notification on website.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <ul class="custom-control-group g-3 align-center flex-wrap">
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="1" name="email_notification" {{$general->email_notification == "1" ? 'checked' : '' }} id="emailnot-enable">
                                                                <label class="custom-control-label" for="emailnot-enable">Enable</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="0" name="email_notification" {{$general->email_notification == "0" ? 'checked' : '' }} id="emailnot-disable">
                                                                <label class="custom-control-label" for="emailnot-disable">Disable</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            {{-- <div class="row g-3 align-center">
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-off">Maintanance Mode</label>
                                                        <span class="form-note">Enable to make website make offline.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <ul class="custom-control-group g-3 align-center flex-wrap">
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="1" name="maintain" {{$general->maintain == "1" ? 'checked' : '' }} id="maintain-enable">
                                                                <label class="custom-control-label" for="maintain-enable">Enable</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="0" name="maintain" {{$general->maintain == "0" ? 'checked' : '' }} id="maintain-disable">
                                                                <label class="custom-control-label" for="maintain-disable">Disable</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div> --}}
                                            <div class="row g-3">
                                                <div class="col-lg-7 offset-lg-5">
                                                    <div class="form-group mt-2">
                                                        <button type="submit" class="btn btn-lg btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div><!-- card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
@endsection
