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

          <!-- Password
          ============================================= -->
          <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 d-flex align-items-center mb-4">Password<a href="#change-password" data-toggle="modal" class="ml-auto text-2 text-uppercase btn-link"><span class="mr-1"><i class="fas fa-edit"></i></span>Change</a></h3>
            <hr class="mx-n4 mb-4">
            <p class="text-3">Create or update your password. - <span class="text-muted">Last changed: @if(auth()->user()->pass_changed != NULL) {{ Carbon\Carbon::parse(auth()->user()->pass_changed)->diffForHumans() }} @else Never @endif</span></p>
          </div>
          <!-- Edit Details Modal
          ================================== -->
          <div id="change-password" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Change Password</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="changePassword" method="POST" action="{{route('change-password')}}">
                    @csrf
                    <div class="form-group">
                      <label for="existingPassword">Confirm Current Password</label>
                      <input type="password" class="form-control" data-bv-field="existingpassword" name="current_password" id="existingPassword" required placeholder="Enter Current Password">
                    </div>
                    <div class="form-group">
                      <label for="newPassword">New Password</label>
                      <input type="password" class="form-control" data-bv-field="newpassword" name="password" id="newPassword" required placeholder="Enter New Password">
                    </div>
                    <div class="form-group">
                      <label for="confirmPassword">Confirm New Password</label>
                      <input type="password" class="form-control" data-bv-field="confirmgpassword" name="password_confirmation" id="confirmPassword" required placeholder="Enter Confirm New Password">
                    </div>
                    <button class="btn btn-primary btn-block mt-4" type="submit" onclick="this.disabled=true;this.innerHTML='Updating, please wait...';this.form.submit();">Update Password</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Password End -->

          <!-- Security Questions
          ============================================= -->
          {{-- <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 d-flex align-items-center mb-4">Security Questions<a href="settings-security.html#change-security-questions" data-toggle="modal" class="ml-auto text-2 text-uppercase btn-link"><span class="mr-1"><i class="fas fa-edit"></i></span>Change</a></h3>
            <hr class="mx-n4 mb-4">
            <p class="text-3">For your protection, please choose 3 security questions. This way, we can verify it’s really you if there’s ever a doubt.</p>
          </div> --}}
          <!-- Edit Details Modal
          ================================== -->
          <div id="change-security-questions" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Security Questions</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <p class="text-3 mb-4">We'll use these questions as a way to make sure it's your account, like if you need to reset your password</p>
                  <form id="changePassword" method="post">
                    <div class="form-group">
                      <label for="question1">Security Question 1</label>
                      <select class="custom-select" id="question1" name="question1">
                        <option value="">Select a question</option>
                        <option value="1">What was your childhood nickname?</option>
                        <option value="2"> What is the name of your favorite childhood friend?</option>
                        <option value="3"> What was the name of your first stuffed animal?</option>
                        <option value="4"> In what city or town did your mother and father meet?</option>
                        <option value="5">What is your youngest brother’s birthday year?</option>
                        <option value="6"> What is your maternal grandmother's maiden name?</option>
                        <option value="7"> In what city or town was your first job?</option>
                        <option value="8"> What is the name of a college you applied to?</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" data-bv-field="answers1" id="answers1" placeholder="Answer">
                    </div>
                    <div class="form-group mt-4">
                      <label for="question2">Security Question 2</label>
                      <select class="custom-select" id="question2" name="question2">
                        <option value="">Select a question</option>
                        <option value="1">What was your childhood nickname?</option>
                        <option value="2"> What is the name of your favorite childhood friend?</option>
                        <option value="3"> What was the name of your first stuffed animal?</option>
                        <option value="4"> In what city or town did your mother and father meet?</option>
                        <option value="5">What is your youngest brother’s birthday year?</option>
                        <option value="6"> What is your maternal grandmother's maiden name?</option>
                        <option value="7"> In what city or town was your first job?</option>
                        <option value="8"> What is the name of a college you applied to?</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" data-bv-field="answers2" id="answers2" placeholder="Answer">
                    </div>
                    <div class="form-group mt-4">
                      <label for="question3">Security Question 3</label>
                      <select class="custom-select" id="question3" name="question3">
                        <option value="">Select a question</option>
                        <option value="1">What was your childhood nickname?</option>
                        <option value="2"> What is the name of your favorite childhood friend?</option>
                        <option value="3"> What was the name of your first stuffed animal?</option>
                        <option value="4"> In what city or town did your mother and father meet?</option>
                        <option value="5">What is your youngest brother’s birthday year?</option>
                        <option value="6"> What is your maternal grandmother's maiden name?</option>
                        <option value="7"> In what city or town was your first job?</option>
                        <option value="8"> What is the name of a college you applied to?</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" data-bv-field="answers3" id="answers3" placeholder="Answer">
                    </div>
                    <button class="btn btn-primary btn-block mt-4" type="submit">Save Changes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Security Questions End -->

          <!-- 2-Step Verification
          ============================================= -->
          {{-- <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 d-flex align-items-center mb-4">2-Step Verification<a href="settings-security.html#two-step-verification" data-toggle="modal" class="ml-auto text-2 text-uppercase btn-link"><span class="mr-1"><i class="fas fa-tools"></i></span>SetUp</a></h3>
            <hr class="mx-n4 mb-4">
            <p class="text-3">Add an extra layer of security to your account by using a one-time security code in addition to your password each time you log in.</p>
          </div> --}}
          <!-- Edit Details Modal
          ================================== -->
          <div id="two-step-verification" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">2-Step Verification</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4 text-center">
                  <p class="lead">Protect your account with 2-step verification</p>
                  <h3 class="text-5 mb-3">Where should we send your one-time code?</h3>
                  <p class="line-height-3">Let’s set up the mobile number where you’ll receive your codes for 2-step verification.</p>
                  <form id="changePassword" method="post">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <select class="custom-select rounded-right-0" id="selectedCountry" name="selectedCountry">
                            <option value="AD,376">AD +376</option>
                            <option value="AE,971">AE +971</option>
                            <option value="AF,93">AF +93</option>
                            <option value="AG,1">AG +1</option>
                            <option value="AI,1">AI +1</option>
                            <option value="AL,355">AL +355</option>
                            <option value="AM,374">AM +374</option>
                            <option value="AN,599">AN +599</option>
                            <option value="AO,244">AO +244</option>
                            <option value="AR,54">AR +54</option>
                            <option value="AS,1">AS +1</option>
                            <option value="AT,43">AT +43</option>
                            <option value="AU,61">AU +61</option>
                            <option value="AW,297">AW +297</option>
                            <option value="AX,358">AX +358</option>
                            <option value="AZ,994">AZ +994</option>
                            <option value="BA,387">BA +387</option>
                            <option value="BB,1">BB +1</option>
                            <option value="BD,880">BD +880</option>
                            <option value="BE,32">BE +32</option>
                            <option value="BF,226">BF +226</option>
                            <option value="BG,359">BG +359</option>
                            <option value="BH,973">BH +973</option>
                            <option value="BI,257">BI +257</option>
                            <option value="BJ,229">BJ +229</option>
                            <option value="BL,590">BL +590</option>
                            <option value="BM,1">BM +1</option>
                            <option value="BN,673">BN +673</option>
                            <option value="BO,591">BO +591</option>
                            <option value="BQ,599">BQ +599</option>
                            <option value="BR,55">BR +55</option>
                            <option value="BS,1">BS +1</option>
                            <option value="BT,975">BT +975</option>
                            <option value="BW,267">BW +267</option>
                            <option value="BY,375">BY +375</option>
                            <option value="BZ,501">BZ +501</option>
                            <option value="CA,1">CA +1</option>
                            <option value="CC,61">CC +61</option>
                            <option value="CD,243">CD +243</option>
                            <option value="CF,236">CF +236</option>
                            <option value="CG,242">CG +242</option>
                            <option value="CH,41">CH +41</option>
                            <option value="CI,225">CI +225</option>
                            <option value="CK,682">CK +682</option>
                            <option value="CL,56">CL +56</option>
                            <option value="CM,237">CM +237</option>
                            <option value="CN,86">CN +86</option>
                            <option value="CO,57">CO +57</option>
                            <option value="CR,506">CR +506</option>
                            <option value="CU,53">CU +53</option>
                            <option value="CV,238">CV +238</option>
                            <option value="CW,599">CW +599</option>
                            <option value="CY,357">CY +357</option>
                            <option value="CZ,420">CZ +420</option>
                            <option value="DE,49">DE +49</option>
                            <option value="DJ,253">DJ +253</option>
                            <option value="DK,45">DK +45</option>
                            <option value="DM,1">DM +1</option>
                            <option value="DO,1">DO +1</option>
                            <option value="DZ,213">DZ +213</option>
                            <option value="EC,593">EC +593</option>
                            <option value="EE,372">EE +372</option>
                            <option value="EG,20">EG +20</option>
                            <option value="ER,291">ER +291</option>
                            <option value="ES,34">ES +34</option>
                            <option value="ET,251">ET +251</option>
                            <option value="FI,358">FI +358</option>
                            <option value="FJ,679">FJ +679</option>
                            <option value="FK,500">FK +500</option>
                            <option value="FM,691">FM +691</option>
                            <option value="FO,298">FO +298</option>
                            <option value="FR,33">FR +33</option>
                            <option value="GA,241">GA +241</option>
                            <option value="GB,44">GB +44</option>
                            <option value="GD,1">GD +1</option>
                            <option value="GE,995">GE +995</option>
                            <option value="GF,594">GF +594</option>
                            <option value="GG,44">GG +44</option>
                            <option value="GH,233">GH +233</option>
                            <option value="GI,350">GI +350</option>
                            <option value="GL,299">GL +299</option>
                            <option value="GM,220">GM +220</option>
                            <option value="GN,224">GN +224</option>
                            <option value="GP,590">GP +590</option>
                            <option value="GQ,240">GQ +240</option>
                            <option value="GR,30">GR +30</option>
                            <option value="GT,502">GT +502</option>
                            <option value="GU,1">GU +1</option>
                            <option value="GW,245">GW +245</option>
                            <option value="GY,592">GY +592</option>
                            <option value="HK,852">HK +852</option>
                            <option value="HN,504">HN +504</option>
                            <option value="HR,385">HR +385</option>
                            <option value="HT,509">HT +509</option>
                            <option value="HU,36">HU +36</option>
                            <option value="ID,62">ID +62</option>
                            <option value="IE,353">IE +353</option>
                            <option value="IL,972">IL +972</option>
                            <option value="IM,44">IM +44</option>
                            <option value="IN,91">IN +91</option>
                            <option value="IO,246">IO +246</option>
                            <option value="IQ,964">IQ +964</option>
                            <option value="IR,98">IR +98</option>
                            <option value="IS,354">IS +354</option>
                            <option value="IT,39">IT +39</option>
                            <option value="JE,44">JE +44</option>
                            <option value="JM,1">JM +1</option>
                            <option value="JO,962">JO +962</option>
                            <option value="JP,81">JP +81</option>
                            <option value="KE,254">KE +254</option>
                            <option value="KG,996">KG +996</option>
                            <option value="KH,855">KH +855</option>
                            <option value="KI,686">KI +686</option>
                            <option value="KM,269">KM +269</option>
                            <option value="KN,1">KN +1</option>
                            <option value="KP,850">KP +850</option>
                            <option value="KR,82">KR +82</option>
                            <option value="KW,965">KW +965</option>
                            <option value="KY,1">KY +1</option>
                            <option value="KZ,7">KZ +7</option>
                            <option value="LA,856">LA +856</option>
                            <option value="LB,961">LB +961</option>
                            <option value="LC,1">LC +1</option>
                            <option value="LI,423">LI +423</option>
                            <option value="LK,94">LK +94</option>
                            <option value="LR,231">LR +231</option>
                            <option value="LS,266">LS +266</option>
                            <option value="LT,370">LT +370</option>
                            <option value="LU,352">LU +352</option>
                            <option value="LV,371">LV +371</option>
                            <option value="LY,218">LY +218</option>
                            <option value="MA,212">MA +212</option>
                            <option value="MC,377">MC +377</option>
                            <option value="MD,373">MD +373</option>
                            <option value="ME,382">ME +382</option>
                            <option value="MF,590">MF +590</option>
                            <option value="MG,261">MG +261</option>
                            <option value="MH,692">MH +692</option>
                            <option value="MK,389">MK +389</option>
                            <option value="ML,223">ML +223</option>
                            <option value="MM,95">MM +95</option>
                            <option value="MN,976">MN +976</option>
                            <option value="MO,853">MO +853</option>
                            <option value="MP,1">MP +1</option>
                            <option value="MQ,596">MQ +596</option>
                            <option value="MR,222">MR +222</option>
                            <option value="MS,1">MS +1</option>
                            <option value="MT,356">MT +356</option>
                            <option value="MU,230">MU +230</option>
                            <option value="MV,960">MV +960</option>
                            <option value="MW,265">MW +265</option>
                            <option value="MX,52">MX +52</option>
                            <option value="MY,60">MY +60</option>
                            <option value="MZ,258">MZ +258</option>
                            <option value="NA,264">NA +264</option>
                            <option value="NC,687">NC +687</option>
                            <option value="NE,227">NE +227</option>
                            <option value="NF,672">NF +672</option>
                            <option value="NG,234">NG +234</option>
                            <option value="NI,505">NI +505</option>
                            <option value="NL,31">NL +31</option>
                            <option value="NO,47">NO +47</option>
                            <option value="NP,977">NP +977</option>
                            <option value="NR,674">NR +674</option>
                            <option value="NU,683">NU +683</option>
                            <option value="NZ,64">NZ +64</option>
                            <option value="OM,968">OM +968</option>
                            <option value="PA,507">PA +507</option>
                            <option value="PE,51">PE +51</option>
                            <option value="PF,689">PF +689</option>
                            <option value="PG,675">PG +675</option>
                            <option value="PH,63">PH +63</option>
                            <option value="PK,92">PK +92</option>
                            <option value="PL,48">PL +48</option>
                            <option value="PM,508">PM +508</option>
                            <option value="PN,64">PN +64</option>
                            <option value="PR,1">PR +1</option>
                            <option value="PS,970">PS +970</option>
                            <option value="PT,351">PT +351</option>
                            <option value="PW,680">PW +680</option>
                            <option value="PY,595">PY +595</option>
                            <option value="QA,974">QA +974</option>
                            <option value="RE,262">RE +262</option>
                            <option value="RO,40">RO +40</option>
                            <option value="RS,381">RS +381</option>
                            <option value="RU,7">RU +7</option>
                            <option value="RW,250">RW +250</option>
                            <option value="SA,966">SA +966</option>
                            <option value="SB,677">SB +677</option>
                            <option value="SC,248">SC +248</option>
                            <option value="SD,249">SD +249</option>
                            <option value="SE,46">SE +46</option>
                            <option value="SG,65">SG +65</option>
                            <option value="SH,290">SH +290</option>
                            <option value="SI,386">SI +386</option>
                            <option value="SJ,47">SJ +47</option>
                            <option value="SK,421">SK +421</option>
                            <option value="SL,232">SL +232</option>
                            <option value="SM,378">SM +378</option>
                            <option value="SN,221">SN +221</option>
                            <option value="SO,252">SO +252</option>
                            <option value="SR,597">SR +597</option>
                            <option value="SS,211">SS +211</option>
                            <option value="ST,239">ST +239</option>
                            <option value="SV,503">SV +503</option>
                            <option value="SX,1">SX +1</option>
                            <option value="SY,963">SY +963</option>
                            <option value="SZ,268">SZ +268</option>
                            <option value="TC,1">TC +1</option>
                            <option value="TD,235">TD +235</option>
                            <option value="TG,228">TG +228</option>
                            <option value="TH,66">TH +66</option>
                            <option value="TJ,992">TJ +992</option>
                            <option value="TK,690">TK +690</option>
                            <option value="TL,670">TL +670</option>
                            <option value="TM,993">TM +993</option>
                            <option value="TN,216">TN +216</option>
                            <option value="TO,676">TO +676</option>
                            <option value="TR,90">TR +90</option>
                            <option value="TT,1">TT +1</option>
                            <option value="TV,688">TV +688</option>
                            <option value="TW,886">TW +886</option>
                            <option value="TZ,255">TZ +255</option>
                            <option value="UA,380">UA +380</option>
                            <option value="UG,256">UG +256</option>
                            <option value="US,1">US +1</option>
                            <option value="UY,598">UY +598</option>
                            <option value="UZ,998">UZ +998</option>
                            <option value="VA,39">VA +39</option>
                            <option value="VC,1">VC +1</option>
                            <option value="VE,58">VE +58</option>
                            <option value="VG,1">VG +1</option>
                            <option value="VI,1">VI +1</option>
                            <option value="VN,84">VN +84</option>
                            <option value="VU,678">VU +678</option>
                            <option value="WF,681">WF +681</option>
                            <option value="WS,685">WS +685</option>
                            <option value="YE,967">YE +967</option>
                            <option value="YT,262">YT +262</option>
                            <option value="ZA,27">ZA +27</option>
                            <option value="ZM,260">ZM +260</option>
                            <option value="ZW,263">ZW +263</option>
                          </select>
                        </div>
                        <input type="text" value="2025550125" class="form-control" data-bv-field="mobilenumber" id="mobileNumber" required placeholder="Mobile Number">
                      </div>
                    </div>
                    <button class="btn btn-primary btn-block mt-4" type="submit">Next</button>
                  </form>
                  <p class="text-muted mt-3">By continuing, you confirm that you are authorized to use this phone number and agree to receive text messages.</p>
                </div>
              </div>
            </div>
          </div>
          <!-- 2-Step Verification End -->

        </div>
        <!-- Middle Panel End -->
      </div>
    </div>
  </div>
  <!-- Content end -->


@endsection
