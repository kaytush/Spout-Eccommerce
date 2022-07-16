        <!-- Left Panel
        ============================================= -->
        <aside class="col-lg-3">

          <!-- Profile Details
          =============================== -->
          <div class="bg-white shadow-sm rounded text-center p-3 mb-4">
            <div class="profile-thumb mt-3 mb-4">
                @if(file_exists(auth()->user()->image))
                    <img class="rounded-circle" src="{{url(auth()->user()->image)}}" width="100px" height="100px" alt="{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}">
                @else
                    <img class="rounded-circle" src="{{url('assets/images/profile.png')}}" width="100px" height="100px" alt="{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}">
                @endif
              <div class="profile-thumb-edit custom-file bg-primary text-white" data-toggle="tooltip" title="Change Profile Picture"> <i class="fas fa-camera position-absolute"></i>
                <input type="file" class="custom-file-input" id="customFile">
              </div>
            </div>
            <p class="text-3 font-weight-500 mb-2">Hello, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p>
            <p class="mb-2"><a href="profile.html" class="text-5 text-light" data-toggle="tooltip" title="Edit Profile"><i class="fas fa-edit"></i></a></p>
          </div>
          <!-- Profile Details End -->

          <!-- Available Balance
          =============================== -->
          <div class="bg-white shadow-sm rounded text-center p-3 mb-4">
            <div class="text-17 text-light my-3"><i class="fas fa-wallet"></i></div>
            <h3 class="text-9 font-weight-400">{{$basic->currency_sym.number_format(auth()->user()->balance, $basic->decimal)}}</h3>
            <p class="mb-2 text-muted opacity-8">Available Balance</p>
            <hr class="mx-n3">
            <div class="d-flex"><a href="javascript:void(0);" class="btn-link mr-auto">Transfer</a> <a href="javascript:void(0);" class="btn-link ml-auto">Deposit</a></div>
          </div>
          <!-- Available Balance End -->

          <!-- Wallet Bonus
          =============================== -->
          <div class="bg-white shadow-sm rounded text-center p-3 mb-4">
            <div class="text-17 text-light my-3"><i class="fas fa-wallet"></i></div>
            <h3 class="text-5 font-weight-400 my-4">{{$basic->currency_sym.number_format(auth()->user()->earning, $basic->decimal)}}</h3>
            <p class="text-muted opacity-8 mb-4">Earning Balance</p>
            <a href="javascript:void(0);" class="btn btn-primary btn-block">Move to Balance</a> </div>
          <!-- Wallet Bonus End -->

        </aside>
        <!-- Left Panel End -->
