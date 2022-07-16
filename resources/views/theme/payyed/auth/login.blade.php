@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

<div id="content">
    <div class="container py-5">
      <div class="row">
        <div class="col-md-9 col-lg-7 col-xl-5 mx-auto">
          <div class="bg-white shadow-md rounded p-3 pt-sm-4 pb-sm-5 px-sm-5">
            <h3 class="font-weight-400 text-center mb-4">Sign In</h3>
            <hr class="mx-n5">
            <p class="lead text-center">We are glad to see you again!</p>

            @error('email')
                <div class="alert alert-info rounded shadow-sm">
                    <div class="form-row align-items-center">
                        {{ $message }}
                    </div>
                </div>
            @enderror

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
              <div class="form-group">
                <label for="emailAddress">{{ __('Email, Username or Phone Number') }}</label>
                <input type="text" class="form-control" id="emailAddress" name="email" required placeholder="Username/ Email / Phone Number">
              </div>
              <div class="form-group">
                <label for="loginPassword">{{ __('Password') }}</label>
                <input type="password" class="form-control" id="loginPassword" name="password" required placeholder="Enter Password">
              </div>
              <div class="row">
                <div class="col-sm">
                  <div class="form-check custom-control custom-checkbox">
                    <input id="remember-me" name="remember" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="remember-me">{{ __('Remember me') }}</label>
                  </div>
                </div>
                <div class="col-sm text-right"><a class="btn-link" href="{{ route('password.request') }}">Forgot Password ?</a></div>
              </div>
              <button class="btn btn-primary btn-block my-4" type="submit" onclick="this.disabled=true;this.innerHTML='Authenticating, please wait...';this.form.requestSubmit();">{{ __('Log in') }}</button>
            </form>
            <p class="text-3 text-muted text-center mb-0">Don't have an account? <a class="btn-link" href="{{ route('register') }}">Sign Up</a></p>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
