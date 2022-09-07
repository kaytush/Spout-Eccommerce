<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etemplate;

class EtemplateController extends Controller
{
    //
    public function index()
    {
        $temp = $data['temp'] = Etemplate::first();
        if(is_null($temp))
        {
            $default = [
                'esender' => 'info@giftingbills.com',
                'emessage' => 'Email Message',
                'smsapi' => 'SMS Message',
                'mobile' => '0703xxxxxxx'
            ];
            Etemplate::create($default);
            $temp = Etemplate::first();
        }

        return view('admin.email_template', $data);
    }


    public function update(Request $request)
    {
        $temp = Etemplate::first();

        $this->validate($request,
               [
                'esender' => 'required',
                'emessage' => 'required',
                'smsapi' => 'required',
//                'mobile' => 'required'
                ]);

//        $temp['mobile'] = $request->mobile;
        $temp['esender'] = $request->esender;
        $temp['emessage'] = $request->emessage;
        $temp['smsapi'] = $request->smsapi;

        $temp->save();

        return back()->with('success', 'Email Settings Updated Successfully!');
    }
}
