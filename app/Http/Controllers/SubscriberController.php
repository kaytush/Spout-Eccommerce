<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    //
    public function manageSubscribers()
    {
        $data['page_title'] = 'Subscribers';
        $data['events'] = Subscriber::latest()->paginate(30);
        return view('admin.subscribers.subscriber', $data);
    }



    public function updateSubscriber($id)
    {
        $mac = Subscriber::findOrFail($id);
        if($mac->status == 1){
            $mac['status'] = 0;
        }elseif ($mac->status == 0) {
            $mac['status'] = 1;
        }

        $res = $mac->save();

        return back()->with('success', 'Subscriber Updated Successfully!');

    }

    public function sendMail()
    {
        $data['page_title'] = 'Mail to Subscribers';
        return view('admin.subscribers.subscriber-email', $data);
    }

    public function sendMailsubscriber(Request $request)
    {
        $this->validate($request,
            [
                'subject' => 'required',
                'message' => 'required'
            ]);
        $subscriber = Subscriber::whereStatus(1)->get();
        $clients = User::whereStatus(1)->get();
        if ($request->receivers == 1) {
            # subscribers only...
            foreach ($subscriber as $data) {
                $to =  $data->email;
                $name = $data->name;
                $subject = $request->subject;
                $message = $request->message;
                send_email($to, $name, $subject, $message);
            }
        }elseif ($request->receivers == 2) {
            # clients only...
            foreach ($clients as $data) {
                $to =  $data->email;
                $name = $data->firstname;
                $subject = $request->subject;
                $message = $request->message;
                send_email($to, $name, $subject, $message);
            }
        }elseif ($request->receivers == 3) {
            # both clients and subscribers...
            foreach ($subscriber as $data) {
                $to =  $data->email;
                $name = $data->name;
                $subject = $request->subject;
                $message = $request->message;
                send_email($to, $name, $subject, $message);
            }
            foreach ($clients as $data) {
                $to =  $data->email;
                $name = $data->firstname;
                $subject = $request->subject;
                $message = $request->emailMessage;
                send_email($to, $name, $subject, $message);
            }
        }

        $notification = array('message' => 'Mail Sent Successfully!', 'alert-type' => 'success');
        return back()->with($notification);
    }
}
