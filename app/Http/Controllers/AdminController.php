<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use App\Models\Admin;
use App\Models\AdminLogin;
use App\Models\Order;
use App\Models\UserLogin;
use App\Models\Counter;
use App\Models\Faq;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use Input;
use Image;
use File;
use Carbon\Carbon;


class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $data['general'] = GeneralSettings::first();
        $year = date('Y');
        $month = date('M');
        $day = date('d');

        //Total Bills
        $data['airtime_sum_amount'] = Transaction::where(['service_type' => "airtime", 'refunded' => 0])->sum('amount');
        $data['internet_sum_amount'] = Transaction::where(['service_type' => "internet", 'refunded' => 0])->sum('amount');
        $data['tv_sum_amount'] = Transaction::where(['service_type' => "tv", 'refunded' => 0])->sum('amount');
        $data['electricity_sum_amount'] = Transaction::where(['service_type' => "electricity", 'refunded' => 0])->sum('amount');
        $data['betting_sum_amount'] = Transaction::where(['service_type' => "betting", 'refunded' => 0])->sum('amount');

        $data['airtime_sum_discount'] = Transaction::where(['service_type' => "airtime", 'refunded' => 0])->sum('discount');
        $data['internet_sum_discount'] = Transaction::where(['service_type' => "internet", 'refunded' => 0])->sum('discount');
        $data['tv_sum_discount'] = Transaction::where(['service_type' => "tv", 'refunded' => 0])->sum('discount');
        $data['electricity_sum_discount'] = Transaction::where(['service_type' => "electricity", 'refunded' => 0])->sum('discount');
        $data['betting_sum_discount'] = Transaction::where(['service_type' => "betting", 'refunded' => 0])->sum('discount');

        $data['airtime_t_count'] = Transaction::where(['service_type' => "airtime", 'refunded' => 0])->count();
        $data['internet_t_count'] = Transaction::where(['service_type' => "internet", 'refunded' => 0])->count();
        $data['tv_t_count'] = Transaction::where(['service_type' => "tv", 'refunded' => 0])->count();
        $data['electricity_t_count'] = Transaction::where(['service_type' => "electricity", 'refunded' => 0])->count();
        $data['betting_t_count'] = Transaction::where(['service_type' => "betting", 'refunded' => 0])->count();

        //Top Subscribed Plans
        // $data['plans'] = Subplan::all();



        return view('admin.dashboard', $data);
    }

    //System General Settings & Config Starts Here
    public function settings()
    {
        $data['general'] = GeneralSettings::first();
        return view('admin.settings', $data);
    }

    public function UpdateSettings(Request $request)
    {
        $request->validate([

            'currency' => 'required',
            'currency_sym' => 'required',
            'sitename' => 'required',
        ],[
            'currency_sym.required' => 'Currency symbol must not be empty',
            ]);


        $gs = GeneralSettings::first();
        $in = Input::except('_token','logo','favicon','logo_white');
        $res = $gs->fill($in)->save();

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $filename = 'logo.png';
            $location = 'assets/images/' . $filename;
            Image::make($image)->save($location);
        }
        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $filename = 'favicon.png';
            $location = 'assets/images/' . $filename;
            Image::make($image)->save($location);
        }
        if ($request->hasFile('logo_white')) {
            $image = $request->file('logo_white');
            $filename = 'logo_white.png';
            $location = 'assets/images/' . $filename;
            Image::make($image)->save($location);
        }

			if ($res) {
				return back()->with('success', 'System Settings Has Been Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}

    public function UpdateOtherSettings(Request $request)
    {
        $gs = GeneralSettings::first();
        $in = Input::except('_token');
        $res = $gs->fill($in)->save();


			if ($res) {
				return back()->with('success', 'System Settings Has Been Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}

    public function paymentSettings()
    {
        $data['general'] = GeneralSettings::first();
        $data['gateway'] = Gateway::first();
        $data['offline'] = Gateway::where('id',2)->first();
        return view('admin.payment-settings', $data);
    }

    public function updateOnGate(Request $request)
    {
        $gateway = Gateway::first();
        $request->validate([
            'main_name' => 'required|string|max:255',
            'val1' => 'required|string|max:255',
        //
        ], [
            'main_name.required' => 'Display name cannot be empty',
            'val1.required' => 'public key cannot be empty',
        ]);
        $in = Input::except('_method', '_token');
        $gateway->fill($in)->save();
        return back()->with("success", "Fluterwave Details Updated Successfully.");
    }

    public function updateOffGate(Request $request)
    {
        $offline = Gateway::where('id',2)->first();
        $request->validate([
            'main_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'val1' => 'required|string|max:255',
            'val2' => 'required|string|max:255',
        //
        ], [
            'main_name.required' => 'Display name cannot be empty',
            'name.required' => 'Bank name cannot be empty',
            'val1.required' => 'Account Name cannot be empty',
            'val2.required' => 'Account Number cannot be empty',
        ]);
        $in = Input::except('_method', '_token');
        $offline->fill($in)->save();
        return back()->with("success", "Bank Payment Details Updated Successfully.");
    }


    //Frontend Settings & Config Starts Here
    public function services($id){
        $data['service'] = Service::where(['id' => $id])->first();
        return view('admin.frontend.services', $data);
    }

    public function serviceDetailUpdate(Request $request)
    {
        $data = Service::find($request->id);

        $request->validate([
            'image' => 'mimes:jpeg,jpg,png,bmp | max:50000',
            'brief' => 'required',
            'details' => 'required',
        //
        ], [
            'image.mimes' => 'Only jpeg,jpg,png,bmp Image supported',
            'brief.required' => 'Service brief cannot be Empty',
            'details.required' => 'Service Details cannot be Empty',
        ]);

        $in = Input::except('_method','_token');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $request->id . '.jpg';
            $location = 'assets/images/service/' . $filename;
            $in['image'] = $location;
            if ($data->image != NULL) {
                $link = $data->image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(370, 270)->save($location);
        }

        $in['brief'] = $request->brief;
        $in['details'] = $request->details;

        $data->fill($in)->save();

        return back()->with('success', 'Service Details Updated Successfully!');
    }

    public function aboutSecOne(){
        $data['about'] = AboutUs::first();
        return view('admin.frontend.about-sec-one', $data);
    }

    public function aboutSecTwo(){
        $data['general'] = GeneralSettings::first();
        $data['about'] = AboutUs::first();
        return view('admin.frontend.about-sec-two', $data);
    }

    public function UpdateAboutUs(Request $request)
    {
        $ab = AboutUs::first();
        $in = Input::except('_token','sec_one_image','sec_two_image');
        // $res = $ab->fill($in)->save();

        if ($request->hasFile('sec_one_image')) {
            $image = $request->file('sec_one_image');
            $filename = time() . 'about-sec-one.png';
            $location = 'assets/images/' . $filename;
            $in['sec_one_image'] = $location;
            if ($ab->sec_one_image != NULL) {
                $link = $ab->sec_one_image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(550, 500)->save($location);
        }
        if ($request->hasFile('sec_two_image')) {
            $image = $request->file('sec_two_image');
            $filename = time() . 'about-sec-two.png';
            $location = 'assets/images/' . $filename;
            $in['sec_two_image'] = $location;
            if ($ab->sec_two_image != NULL) {
                $link = $ab->sec_two_image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(550, 500)->save($location);
        }
        $res = $ab->fill($in)->save();

			if ($res) {
				return back()->with('success', 'About Section Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}

    public function teams(){
        $data['teams'] = Team::all();
        return view('admin.frontend.teams', $data);
    }

    public function newTeam(Request $request){

        $request->validate([
            'image' => 'mimes:jpeg,jpg,png,bmp | max:50000',
        //
        ], [
            'image.mimes' => 'Only jpeg,jpg,png,bmp Image supported',
        ]);
        $shortname = explode(' ', $request->name);
        $newname = $shortname[0];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $newname . '.jpg';
            $location = 'assets/images/team/' . $filename;
            $team['image'] = $location;
            Image::make($image)->resize(270, 300)->save($location);
        }

        $team['name'] = $request->name;
        $team['email'] = $request->email;
        $team['phone'] = $request->phone;
        $team['role'] = $request->role;
        $team['facebook'] = $request->facebook;
        $team['twitter'] = $request->twitter;
        $team['instagram'] = $request->instagram;
        $team['linkedin'] = $request->linkedin;
        Team::create($team);
        return back()->with('success', 'New Team Member Created Successfully!');
    }

    public function editTeam(Request $request){
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png,bmp | max:50000',
        //
        ], [
            'image.mines' => 'Only jpeg,jpg,png,bmp Image supported',
        ]);
        $data = Team::find($request->id);
        $in = Input::except('_method','_token');
        $shortname = explode(' ', $request->name);
        $newname = $shortname[0];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $newname . '.jpg';
            $location = 'assets/images/team/' . $filename;
            $in['image'] = $location;
            if ($data->image != NULL) {
                $link = $data->image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(270, 300)->save($location);
        }
        $in['name'] = $request->name;
        $in['email'] = $request->email;
        $in['phone'] = $request->phone;
        $in['role'] = $request->role;
        $in['facebook'] = $request->facebook;
        $in['twitter'] = $request->twitter;
        $in['instagram'] = $request->instagram;
        $in['linkedin'] = $request->linkedin;
        $data->fill($in)->save();
        return back()->with('success', 'Team Member Details Edited Successfully!');
    }

    public function actTeam($id){
        $team = Team::findorFail($id);
        $team['status'] = 1;
        $res = $team->save();

        if ($res) {
            return back()->with('success', 'Team Enabled Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Team');
        }
    }

    public function deactTeam($id){
        $team = Team::findorFail($id);
        $team['status'] = 0;
        $res = $team->save();

        if ($res) {
            return back()->with('success', 'Team Disabled Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Team');
        }
    }

    public function partners(){
        $data['partners'] = Partner::all();
        return view('admin.frontend.partners', $data);
    }

    public function newPartner(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required | mimes:jpeg,jpg,png,bmp | max:50000',
        //
        ], [
            'name.required' => 'Partner Name Required',
            'image.required' => 'Only jpeg,jpg,png,bmp Image supported',
        ]);
        $shortname = explode(' ', $request->name);
        $newname = $shortname[0];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $newname . '.png';
            $location = 'assets/images/partner/' . $filename;
            $partner['image'] = $location;
            Image::make($image)->resize(150, 150)->save($location);
        }

        $partner['name'] = $request->name;
        Partner::create($partner);
        return back()->with('success', 'New Partner Created Successfully!');
    }

    public function editPartner(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required | mimes:jpeg,jpg,png,bmp | max:50000',
        //
        ], [
            'name.required' => 'Partner Name Required',
            'image.required' => 'Only jpeg,jpg,png,bmp Image supported',
        ]);
        $data = Partner::find($request->id);
        $in = Input::except('_method','_token');
        $shortname = explode(' ', $request->name);
        $newname = $shortname[0];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $newname . '.png';
            $location = 'assets/images/partner/' . $filename;
            $in['image'] = $location;
            if ($data->image != NULL) {
                $link = $data->image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(150, 150)->save($location);
        }
        $in['name'] = $request->name;
        $data->fill($in)->save();
        return back()->with('success', 'Partner Details Edited Successfully!');
    }

    public function actPartner($id){
        $partner = Partner::findorFail($id);
        $partner['status'] = 1;
        $res = $partner->save();

        if ($res) {
            return back()->with('success', 'Partner Enabled Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Partner');
        }
    }

    public function deactPartner($id){
        $partner = Partner::findorFail($id);
        $partner['status'] = 0;
        $res = $partner->save();

        if ($res) {
            return back()->with('success', 'Partner Disabled Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Partner');
        }
    }

    public function counters(){
        $data['counters'] = Counter::all();
        return view('admin.frontend.counters', $data);
    }

    public function editCounter(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'subvalue' => 'required|string|max:255',
            'icon' => 'mimes:svg',
        //
        ], [
            'title.required' => 'Counter Title Required',
            'value.required' => 'Counter Value Required',
            'subvalue.required' => 'Counter Sub Value Required',
            'icon.mimes' => 'Only SVG supported',
        ]);
        $data = Counter::find($request->id);
        $in = Input::except('_method','_token');
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = $icon->getClientOriginalName();
            $location = $icon->move('assets/images/svg/' , $filename);
            $in['icon'] = $filename;
            if ($data->icon != NULL) {
                $link = 'assets/images/svg/'.$data->icon;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
        }
        $in['title'] = $request->title;
        $in['value'] = $request->value;
        $in['subvalue'] = $request->subvalue;
        $data->fill($in)->save();
        return back()->with('success', 'Counter Updated Successfully!');
    }

    public function testimonials(){
        $data['testimonials'] = Testimonial::all();
        return view('admin.frontend.testimonials', $data);
    }

    public function newTestimonial(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'comment' => 'required|string',
            'image' => 'required | mimes:jpeg,jpg,png,bmp | max:50000',
        //
        ], [
            'name.required' => 'Testimonial Name Required',
            'role.required' => 'Testimonial Role Required',
            'comment.required' => 'Testimonial Comment Required',
            'image.required' => 'Only jpeg,jpg,png,bmp Image supported',
        ]);
        $shortname = explode(' ', $request->name);
        $newname = $shortname[0];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $newname . '.png';
            $location = 'assets/images/testimonial/' . $filename;
            $testimonial['image'] = $location;
            Image::make($image)->resize(211, 211)->save($location);
        }

        $testimonial['name'] = $request->name;
        $testimonial['role'] = $request->role;
        $testimonial['comment'] = $request->comment;
        Testimonial::create($testimonial);
        return back()->with('success', 'New Testimonial Created Successfully!');
    }

    public function editTestimonial(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'comment' => 'required|string',
            'image' => 'mimes:jpeg,jpg,png,bmp | max:50000',
        //
        ], [
            'name.required' => 'Testimonial Name Required',
            'role.required' => 'Testimonial Role Required',
            'comment.required' => 'Testimonial Comment Required',
            'image.mimes' => 'Only jpeg,jpg,png,bmp Image supported',
        ]);
        $data = Testimonial::find($request->id);
        $in = Input::except('_method','_token');
        $shortname = explode(' ', $request->name);
        $newname = $shortname[0];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $newname . '.png';
            $location = 'assets/images/testimonial/' . $filename;
            $in['image'] = $location;
            if ($data->image != NULL) {
                $link = $data->image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(211, 211)->save($location);
        }
        $in['name'] = $request->name;
        $in['role'] = $request->role;
        $in['comment'] = $request->comment;
        $data->fill($in)->save();
        return back()->with('success', 'Testimonial Details Edited Successfully!');
    }

    public function actTestimonial($id){
        $testimonial = Testimonial::findorFail($id);
        $testimonial['status'] = 1;
        $res = $testimonial->save();

        if ($res) {
            return back()->with('success', 'Testimonial Enabled Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Testimonial');
        }
    }

    public function deactTestimonial($id){
        $testimonial = Testimonial::findorFail($id);
        $testimonial['status'] = 0;
        $res = $testimonial->save();

        if ($res) {
            return back()->with('success', 'Testimonial Disabled Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Testimonial');
        }
    }

    //Home Header Content
    public function homeHeader()
    {
        $data['general'] = GeneralSettings::first();
        return view('admin.frontend.home-header', $data);
    }

    public function UpdatehomeHeader(Request $request)
    {
        $gs = GeneralSettings::first();
        $in = Input::except('_token','home_image');

        if ($request->hasFile('home_image')) {
            $image = $request->file('home_image');
            $filename = time() . 'home_head.png';
            $location = 'assets/images/' . $filename;
            $in['home_image'] = $location;
            if ($gs->home_image != NULL) {
                $link = $gs->home_image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(579, 801)->save($location);
        }

        $res = $gs->fill($in)->save();

			if ($res) {
				return back()->with('success', 'Home Header Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}

    //Terms & Conditions Content
    public function terms()
    {
        $data['general'] = GeneralSettings::first();
        return view('admin.frontend.terms', $data);
    }

    public function UpdateTerms(Request $request)
    {
        $gs = GeneralSettings::first();
        $in = Input::except('_token');

        $res = $gs->fill($in)->save();

			if ($res) {
				return back()->with('success', 'Terms & Conditions Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}

    //Privacy Policy Content
    public function privacy()
    {
        $data['general'] = GeneralSettings::first();
        return view('admin.frontend.privacy', $data);
    }

    public function UpdatePrivacy(Request $request)
    {
        $gs = GeneralSettings::first();
        $in = Input::except('_token');

        $res = $gs->fill($in)->save();

			if ($res) {
				return back()->with('success', 'Privacy Policy Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}

    //FAQs
    public function faqs(){
        $data['faqs'] = Faq::all();
        return view('admin.frontend.faq', $data);
    }

    public function createFaqs (Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        Faq::create($in);
        return back()->with('success', 'FAQ Created Successfully!');
    }

    public function updateFaqs(Request $request, $id)
    {
        $faqs = Faq::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        $faqs->fill($in)->save();

        return back()->with('success', 'FAQ Updated Successfully!');

    }

    public function deleteFaqs($id)
    {
       Faq::destroy($id);
        return back()->with('success', 'FAQ Deleted Successfully!');
    }


    // Admin Profile & Logs Starts Here
    public function profile()
    {
        return view('admin.profile');
    }

    public function profilePic(){
        $data['general'] = GeneralSettings::first();
        return view('admin.profile-picture', $data);
    }

    public function profileImage(Request $request)
    {
        $admin = Admin::findOrFail(auth()->guard('admin')->user()->id);
        $request->validate([
            'image' => 'required | mimes:jpeg,jpg,png,bmp | max:50000',
        //
        ], [
            'image.required' => 'Only jpeg,jpg,png,bmp Image supported',
        ]);
        $in = Input::except('_method', '_token');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $request->username . '.jpg';
            $location = 'assets/images/admin/' . $filename;
            $in['image'] = $location;
            if ($admin->image != 'admin-default.png') {
                $path = './assets/images/admin/';
                $link = $path . $admin->image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(800, 800)->save($location);

            $admin->fill($in)->save();
            return back()->with(["success"=>"Your Profile Has Been Updated Successfully"]);
        }
        // $admin->fill($in)->save();
        return back()->with(["error"=>"Error Updating your Profile Picture"]);

    }

    public function profilePersonal(Request $request)
    {
        $admin = Admin::findOrFail(auth()->guard('admin')->user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'phone' => 'required|string|min:11',
        //
        ], [
            'name.required' => 'Fullname must not be empty',
            'username.required' => 'Username must not be empty',
        ]);
        $in = Input::except('_method', '_token');
        $admin->fill($in)->save();
        return back()->with("success", "Your Profile Has Been Updated Successfully.");

    }

    public function profileAddress(Request $request)
    {
        $admin = Admin::findOrFail(auth()->guard('admin')->user()->id);
        $request->validate([
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        //
        ], [
            'city.required' => 'City must not be empty',
            'address.required' => 'Address must not be empty',
            'state.required' => 'State must not be empty',
        ]);
        $in = Input::except('_method', '_token');
        $admin->fill($in)->save();
        return back()->with("success", "Your Profile Has Been Updated Successfully.");

    }

    public function accountActivity(){
        $data['general'] = GeneralSettings::first();
        $data['logs'] = AdminLogin::where('admin_id', auth()->guard('admin')->user()->id)->latest()->take(10)->get();
        return view('admin.account-activity', $data);
    }

    public function securitySettings(){
        $data['general'] = GeneralSettings::first();
        return view('admin.security-settings', $data);
    }

    public function updateActiveLog(Request $request){
        $admin = Admin::findOrFail($request->admin_id);
        $admin->save_log = $request->save_log;
        $admin->save();

        return response()->json(['message' => 'Activity Log Status Updated.']);
    }

    public function changePassword(){
        return view('admin.change-password');
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);

        $current_password = $request->current_password;
        $new_password = $request->password;
        if (Hash::check($current_password, auth()->guard('admin')->user()->password)) {
            $admin = Admin::findOrFail($request->id);
            $admin->fill(['password' => Hash::make($new_password), 'pass_changed' => Carbon::now()])->save();

            return back()->with("success", "Password Changes Successfully.");
        } else {
            return back()->with("alert", "Current Password Not Match");
        }
    }

}
