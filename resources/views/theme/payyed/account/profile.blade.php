@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

  <!-- Content
  ============================================= -->
  <div id="content" class="py-4">
    <div class="container">
      <div class="row">

        @include('theme.'.$basic->theme.'.layouts.leftpanel')
        <!-- Middle Panel
        ============================================= -->
        <div class="col-lg-9">

          <!-- Personal Details
          ============================================= -->
          <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 d-flex align-items-center mb-4">Personal Details<a href="#edit-personal-details" data-toggle="modal" class="ml-auto text-2 text-uppercase btn-link"><span class="mr-1"><i class="fas fa-edit"></i></span>Edit</a></h3>
            <hr class="mx-n4 mb-4">
            <div class="form-row align-items-center">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Name:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p>
            </div>
            <div class="form-row align-items-center">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Email:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->email }}</p>
            </div>
            <div class="form-row align-items-center">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Username:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->username }}</p>
            </div>
            <div class="form-row align-items-center">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Phone:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->phone }}</p>
            </div>
            <div class="form-row align-items-center">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">BVN:</p>
              <p class="col-sm-9 text-3">@if(auth()->user()->bvn != NULL)•••• •••• {{substr(auth()->user()->bvn, -4)}} @endif</p>
            </div>
            <div class="form-row align-items-baseline">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Address:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->address }}</p>
            </div>
            <div class="form-row align-items-baseline">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">City:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->city }}</p>
            </div>
            <div class="form-row align-items-baseline">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">State:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->state }}</p>
            </div>
            <div class="form-row align-items-baseline">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Gender:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->gender }}</p>
            </div>
            <div class="form-row align-items-baseline">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth:</p>
              <p class="col-sm-9 text-3">{{ auth()->user()->dob }}</p>
            </div>
          </div>
          <!-- Edit Details Modal
          ================================== -->
          <div id="edit-personal-details" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Personal Details</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="personaldetails" action="{{route('update-profile')}}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="firstName">First Name</label>
                          <input type="text" value="{{auth()->user()->firstname}}" name="firstname" class="form-control" data-bv-field="firstName" id="firstName" required @if(auth()->user()->bvn_status == 1) readonly @endif>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="fullName">Last Name</label>
                          <input type="text" value="{{auth()->user()->lastname}}" name="lastname" class="form-control" data-bv-field="fullName" id="fullName" required @if(auth()->user()->bvn_status == 1) readonly @endif>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        @if(auth()->user()->bvn_status == 1)
                            <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" value="{{auth()->user()->gender}}" name="gender" class="form-control" data-bv-field="gender" id="gender" required @if(auth()->user()->bvn_status == 1) readonly @endif>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="inputCountry">Gender</label>
                                <select class="custom-select" id="gender" name="gender">
                                    @if (auth()->user()->gender == 'Male')
                                        <option value="Male" selected>Male</option>
                                        <option value="Female">Female</option>
                                    @elseif (auth()->user()->gender == 'Female')
                                        <option value="Female" selected>Female</option>
                                        <option value="Male">Male</option>
                                    @else
                                        <option>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    @endif
                                </select>
                            </div>
                        @endif
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="dob">Date of Birth</label>
                          <input type="date" value="{{auth()->user()->dob}}" name="dob" class="form-control" data-bv-field="dob" id="dob" required @if(auth()->user()->bvn_status == 1) readonly @endif>
                        </div>
                      </div>
                      <div class="col-12">
                        <h3 class="text-5 font-weight-400 mt-3">Address</h3>
                        <hr>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="address">Address</label>
                          <input type="text" value="{{auth()->user()->address}}" name="address" class="form-control" data-bv-field="address" id="address" required placeholder="Address" required>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="city">City</label>
                          <input type="text" value="{{auth()->user()->city}}" name="city" class="form-control" data-bv-field="city" id="city" required>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                      <div class="form-group">
                            <label for="state">State</label>
                            <select class="custom-select" id="state" name="state" required>
                                @if (auth()->user()->state == NULL)
                                    <option value="" selected>Select State</option>
                                @else
                                    <option value="{{auth()->user()->state}}" selected>{{ auth()->user()->state }}</option>
                                @endif
                                @foreach ($states as $data)
                                    <option value="{{ $data->name }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-primary btn-block mt-2" type="submit">Save Changes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Personal Details End -->

          <!-- Account Settings
          ============================================= -->
          <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 d-flex align-items-center mb-4">BVN Verification @if(auth()->user()->bvn_status != 1) <a href="#edit-account-settings" data-toggle="modal" class="ml-auto text-2 text-uppercase btn-link"><span class="mr-1"><i class="fas fa-edit"></i></span>Verify Now</a> @endif</h3>
            <hr class="mx-n4 mb-4">
            @if(auth()->user()->bvn_acc_details != NULL)
                @php
                    $acc = json_decode(auth()->user()->bvn_acc_details,TRUE);
                @endphp
                <div class="form-row align-items-center">
                <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Bank Name:</p>
                <p class="col-sm-9 text-3">{{$acc['bank_name']}}</p>
                </div>
                <div class="form-row align-items-center">
                <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Account Name:</p>
                <p class="col-sm-9 text-3">{{$acc['account_name']}}</p>
                </div>
                <div class="form-row align-items-center">
                <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Account Number:</p>
                <p class="col-sm-9 text-3">{{$acc['account_number']}}</p>
                </div>
            @endif
            <div class="form-row align-items-center">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">BVN Status:</p>
              <p class="col-sm-9 text-3">
                @if(auth()->user()->bvn_status == 1)
                    <span class="bg-success text-white rounded-pill d-inline-block px-2 mb-0"><i class="fas fa-check-circle"></i> Verified</span>
                @else
                    <span class="bg-danger text-white rounded-pill d-inline-block px-2 mb-0"><i class="fas fa-times"></i> Unverified</span>
                @endif
            </p>
            </div>
          </div>
          <!-- Edit Details Modal
          ================================== -->
          <div id="edit-account-settings" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Account Match BVN Verifier</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="accountSettings" action="{{route('verify-bvn')}}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="language">Bank Name</label>
                          <select id="provider" onchange="vverify(this.value)" class="custom-select" name="bank_code">
                          @if (env('TRANSFER_PROVIDER') == 'paylony')
                            @foreach ($list as $data)
                                <option value="{{$data['code']}}" data-bank="{{$data['name']}}">{{$data['name']}}</option>
                            @endforeach
                          @else
                            @foreach ($list as $data)
                                <option value="{{$data['bank_code']}}" data-bank="{{$data['bank_name']}}">{{$data['bank_name']}}</option>
                            @endforeach
                          @endif
                          </select>
                          <input type="hidden" id="bankName" name="bankName" value="" />
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="input-timezone">Account Number</label>
                          <input type="number" name="number" class="form-control" data-bv-field="number" id="number" onkeyup="vverify(this.value)" autocomplete="offInput" minlength="10" maxlength="10" required>
                        </div>
                      </div>
                       <div class="col-12">
                            <p class="text-muted text-center"><span class="font-weight-500" id="accname"></span></p>
                       </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="accountStatus">BVN</label>
                          <input type="number" name="bvn" class="form-control" data-bv-field="bvn" id="bvn" onkeyup="checkSub()" autocomplete="offInput" minlength="10" maxlength="10" required>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" id="acc_name" name="acc_name" />
                    <button id="show" class="btn btn-primary btn-block" disabled onclick="this.form.requestSubmit(); mySubmitFunction();">Confirm</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Account Settings End -->

        </div>
        <!-- Middle Panel End -->
      </div>
    </div>
  </div>
  <!-- Content end -->

  <script>
    function mySubmitFunction() {
        var bvn = $('#bvn').val();
        var number = $('#number').val();
        var provider = $("#provider option:selected").val();

        if (bvn != "" && bvn.length > 10 && number != "" && number.length > 9) {
            document.getElementById("show").innerHTML = "<div class='spinner'><div class='double-bounce1'></div><div class='double-bounce2'></div></div>";
            document.getElementById("show").disabled = true;
        }
    };

    function checkSub() {
        var bvn = $('#bvn').val();
        var number = $('#number').val();
        var acc_name = $('#acc_name').val();

        if (acc_name != "" && bvn != "" && bvn.length > 10 && number != "" && number.length > 9) {
            document.getElementById("show").innerHTML = "Confirm";
            document.getElementById("show").disabled = false;
        }else{
            document.getElementById("show").innerHTML = "Confirm";
            document.getElementById("show").disabled = true;
        }
    };

    function vverify(number) {
        var provider = $("#provider option:selected").val();
        var type = $('#number').attr('data-type');
        var bvn = $('#bvn').val();

        if (number.length > 9) {
            document.getElementById("accname").innerHTML = "Verifying....";
            document.getElementById("show").disabled = true;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var jRes=JSON.parse(this.responseText);
                    console.log(jRes);
                    if(jRes.success){
                        $("#acc_name").val(jRes.data.account_name);
                        document.getElementById("accname").innerHTML = jRes.data.account_name;
                        if(bvn.length > 10){
                            document.getElementById("show").innerHTML = "Confirm";
                            document.getElementById("show").disabled = false;
                        }else{
                            document.getElementById("show").innerHTML = "Confirm";
                            document.getElementById("show").disabled = true;
                        }

                    }else{
                        $("#acc_name").val("-");
                        document.getElementById("accname").innerHTML = "-";
                        document.getElementById("show").innerHTML = "Confirm";
                        document.getElementById("show").disabled = true;
                    }
                }
            };
            xmlhttp.open("GET", "/account_name/validate/"+provider+"/"+number, true);
            xmlhttp.send();
        }
    }
  </script>

@endsection
