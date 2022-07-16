@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

<div id="content">
    <div class="container py-5">
      <div class="row">
        <div class="col-md-9 col-lg-7 col-xl-5 mx-auto">
          <div class="bg-white shadow-md rounded p-3 pt-sm-4 pb-sm-5 px-sm-5">
            <h3 class="font-weight-400 text-center mb-4">Sign Up</h3>
            <hr class="mx-n4">
            <p class="lead text-center">Your information is safe with us.</p>
            <x-jet-validation-errors class="mb-4" />
            <form id="signupForm" method="POST" action="{{ route('register') }}">
                @csrf
              <div class="form-group">
                <label for="fullName">Firstname</label>
                <input type="text" class="form-control" id="fullName" name="firstname" required placeholder="Enter Firstname">
              </div>
              <div class="form-group">
                <label for="fullName">Lastname</label>
                <input type="text" class="form-control" id="fullName" name="lastname" required placeholder="Enter Lastname">
              </div>
              <div class="form-group">
                <label for="emailAddress">Email Address</label>
                <input type="email" class="form-control" id="emailAddress" name="email" required placeholder="Enter Your Email">
              </div>
              <div class="form-group">
                <label for="fullName">Username</label>
                <input type="text" class="form-control" id="username" name="username" required placeholder="Enter Username">
              </div>

              <div class="form-group">
                <label for="emailAddress">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required placeholder="Enter Your Phone Number">
              </div>
              <div class="form-group">
                <label for="loginPassword">{{ __('Password') }}</label>
                <input type="password" class="form-control" id="loginPassword" name="password" required placeholder="Enter Password">
              </div>
              <div class="form-group">
                <label for="loginPassword">{{ __('Confirm Password') }}</label>
                <input type="password" class="form-control" id="loginPassword" name="password_confirmation" required placeholder="Confirm Password">
              </div>
              <button class="btn btn-primary btn-block my-4" type="submit" onclick="this.disabled=true;this.innerHTML='Registering...';this.form.requestSubmit();">Sign Up</button>
            </form>
            <p class="text-3 text-muted text-center mb-0">Already have an account? <a class="btn-link" href="{{ route('login') }}">Log In</a></p>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
