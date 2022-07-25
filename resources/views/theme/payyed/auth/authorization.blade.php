@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', "Email Verification")

@section('content')

<div id="content">
    <div class="container py-5">
      <div class="row">
        <div class="col-md-9 col-lg-7 col-xl-5 mx-auto">
          <div class="bg-white shadow-md rounded p-3 pt-sm-4 pb-sm-5 px-sm-5">
            <h3 class="font-weight-400 text-center mb-4">Email Verification</h3>
            <hr class="mx-n5">
            <p class="lead text-center">Check your email for Verification Code</p>

            @error('email')
                <div class="alert alert-info rounded shadow-sm">
                    <div class="form-row align-items-center">
                        {{ $message }}
                    </div>
                </div>
            @enderror

            <form id="loginForm" method="POST" action="{{ route('email-verify') }}">
                @csrf
              <div class="form-group">
                <label for="emailAddress">{{ __('Verification Code') }}</label>
                <input type="text" class="form-control" id="emailAddress" name="email_code" required placeholder="">
              </div>
              <button class="btn btn-primary btn-block my-4" type="submit" onclick="this.disabled=true;this.innerHTML='Authenticating, please wait...';this.form.requestSubmit();">{{ __('Verify Now') }}</button>
            </form>
            <form  action="{{route('send-emailVcode') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="emailAddress">Didn't get any code? <button type="submit" class="">Resend Code</button></label>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
