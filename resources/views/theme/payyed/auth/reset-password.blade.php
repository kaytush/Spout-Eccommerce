@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

<div id="content">
    <div class="container py-5">
      <div class="row">
        <div class="col-md-9 col-lg-7 col-xl-5 mx-auto">
          <div class="bg-white shadow-md rounded p-3 pt-sm-4 pb-sm-5 px-sm-5">
            <h3 class="font-weight-400 text-center mb-4">Reset Password</h3>
            <hr class="mx-n5">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <x-jet-validation-errors class="mb-4" />
            <p class="lead text-center">{{ __('Set New Password to secure your account') }}</p>
            <form id="loginForm" method="POST" action="{{ route('password.update') }}">
                @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
              <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{$request->email}}" required placeholder="Enter Your Email">
              </div>
              <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter New Password">
              </div>
              <div class="form-group">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirm New Password">
              </div>
              <button class="btn btn-primary btn-block my-4" type="submit" onclick="this.disabled=true;this.innerHTML='Resetting, please wait...';this.form.requestSubmit();">{{ __('Reset Password') }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
