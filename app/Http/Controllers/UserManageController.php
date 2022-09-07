<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\BillsHistory;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\ConvertAirtimeLog;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class UserManageController extends Controller
{
    //
    public function index()
    {
        $data['general'] = GeneralSettings::first();
        $data['clients'] = User::latest()->paginate(20);
        return view('admin.client.index', $data);
    }

    public function clientDetails($id)
    {
        $data['timenow'] = Carbon::now();
        $data['general'] = GeneralSettings::first();
        $data['client'] = User::where('id', $id)->first();
        $data['lastlogin'] = UserLogin::where('user_id', $id)->latest()->take(100)->first();
        $data['transactions'] = Transaction::where('user_id', $id)->latest()->take(1500)->get();
        $data['deposits'] = Deposit::where('user_id', $id)->latest()->take(500)->get();
        $data['bills'] = Transaction::where('user_id', $id)->latest()->take(1500)->get();
        $data['transfers'] = Transfer::where('from', $id)->orWhere('to', $id)->latest()->take(500)->get();
        return view('admin.client.details', $data);
    }

    //fund client
    public function clientFund(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'reason' => 'required|string',
            'wallet' => 'required|string',
            'status' => 'required|numeric',
        //
        ], [
            'id.required' => 'Client ID Required',
            'amount.required' => 'Amount Required',
            'amount.numeric' => 'Amount must not include letters',
            'reason.required' => 'provide purpose Required',
            'wallet.required' => 'Select Wallet to credit or debit',
            'status.required' => 'Status Required',
        ]);

        $client = User::where('id', $request->id)->first();

        if($request->wallet == "balance"){
            if($request->status == 1){
                $client->balance += $request->amount;
            }elseif($request->status == 0){
                $client->balance -= $request->amount;
            }
        }elseif($request->wallet == "earning"){
            if($request->status == 1){
                $client->earning += $request->amount;
            }elseif($request->status == 0){
                $client->earning -= $request->amount;
            }
        }elseif($request->wallet == "cashback"){
            if($request->status == 1){
                $client->cashback += $request->amount;
            }elseif($request->status == 0){
                $client->cashback -= $request->amount;
            }
        }elseif($request->wallet == "airtel_cg"){
            if($request->status == 1){
                $client->airtel_cg += $request->amount;
            }elseif($request->status == 0){
                $client->airtel_cg -= $request->amount;
            }
        }elseif($request->wallet == "mtn_cg"){
            if($request->status == 1){
                $client->mtn_cg += $request->amount;
            }elseif($request->status == 0){
                $client->mtn_cg -= $request->amount;
            }
        }elseif($request->wallet == "mtn_sme"){
            if($request->status == 1){
                $client->mtn_sme += $request->amount;
            }elseif($request->status == 0){
                $client->mtn_sme -= $request->amount;
            }
        }

        $gnl = GeneralSettings::first();
        $trx = Carbon::now()->timestamp . rand();
        if($request->wallet == "balance" || $request->wallet == "earning" || $request->wallet == "cashback"){
            $description = 'Account Credit/Debit by Admin with the sum of '.$request->amount.' '.$gnl->currency;
        }else{
            $description = 'CG Wallet Credit/Debit by Admin with a of sum of '.$request->amount.'GB ';
        }

        //log transaction history
        Transaction::create([
            'user_id' => $client->id,
            'title' => 'Wallet Funding',
            'description' => $description,
            'service' => $request->wallet,
            'amount' => $request->amount,
            'type' => $request->status,
            'trx' => $trx,
        ]);

        $client->save();

        $subject = "Account Funding by GiftBills Admin";
        $msg = $description;
        send_email($client->email, $client->firstname, $subject, $msg);

        return back()->with(["success"=>"Client Credit/Debit Successfully"]);
    }

    public function clientSendmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        //
        ], [
            'subject.required' => 'Email Subject Required',
            'message.required' => 'Email Message Content Required',
        ]);

        $client = User::where('id', $request->id)->first();

        send_email($client->email, $client->firstname, $request->subject, $request->message);

        return back()->with(["success"=>"Email Sent to Client Successfully"]);
    }

    public function upgradeClient($id){
        $client = User::findorFail($id);
        $client['level'] = 1;
        $res = $client->save();

        if ($res) {
            return back()->with('success', 'Client Upgraded Successfully!');
        } else {
            return back()->with('alert', 'Problem Upgrading Client');
        }
    }

    public function act($id){
        $client = User::findorFail($id);
        $client['status'] = 1;
        $res = $client->save();

        if ($res) {
            return back()->with('success', 'Client Activated Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Client');
        }
    }

    public function deact($id){
        $client = User::findorFail($id);
        $client['status'] = 0;
        $res = $client->save();

        if ($res) {
            return back()->with('success', 'Client Deactivated Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Client');
        }
    }

    public function deacttfa($id){
        $client = User::findorFail($id);
        $client['tfa'] = 0;
        $res = $client->save();

        if ($res) {
            return back()->with('success', 'Client 2FA Deactivated Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating Client');
        }
    }

    // manual approve - Flutterwave callback
    public function approveFlPayment($trx)
    {
        $deposit=Deposit::where('trx', $trx)->first();
        if($deposit->status == 1){
            return back()->with(["alert"=>"Deposit already funded"]);
        }
        $deposit->status=1;
        $deposit->save();

        $gnl = GeneralSettings::first();

        $checktrans=Transaction::where('trx', $trx)->first();

        if(! $checktrans){
            //log transaction history
            $u=User::find($deposit->user_id);

            Transaction::create([
                'user_id' => $deposit->id,
                'title' => 'Wallet Funding',
                'service_type' => "deposit",
                'icon' => $deposit->gateway,
                'provider' => $deposit->gateway,
                'recipient' => $u->username,
                'description' => 'You funded your wallet balance with the sum of '.$gnl->currency_sym.$deposit->amount,
                'amount' => $deposit->amount,
                'discount' => 0,
                'fee' => 0,
                'total' => $deposit->amount,
                'init_bal' => $u->balance,
                'new_bal' => $u->balance + $deposit->amount,
                'wallet' => "balance",
                'reference' => NULL,
                'trx' => $trx,
                'channel' => "WEBSITE",
                'type' => 1,
                'status' => "successful",
                'errorMsg' => NULL,

            ]);
        }

        $u=User::find($deposit->user_id);
        $u->balance+=$deposit->amount;
        $u->save();


        $to = $u->email;
        $name = $u->firstname;
        $subject = "Deposit Successful";
        $message = "You have successfully funded your wallet balance with the sum of " . $gnl->currency."". $deposit->amount . " via Flutterwave <br>Thank you for choosing " . $gnl->sitename;
        send_email($to, $name, $subject, $message);

        return back()->with(["success"=>"Client Fund Added Successfully"]);
    }

    // convert airtime approval
    public function approveAirtimeConvert($id)
    {
        $convert=ConvertAirtimeLog::where('id', $id)->where('status', 0)->first();

        if($convert != NULL){
            $gnl = GeneralSettings::first();
            $trx = Carbon::now()->timestamp . rand();

            if($convert->type == "bank"){
                $title = "Airtime to Cash Withdrawal Successful";
                $description = 'You exchanged your airtime for cash, paid to your bank account.';
            }elseif($convert->type == "wallet"){
                $title = "Wallet Funding Successful";
                $description = 'You funded your wallet balance via airtime to cash transfer';
            }

            //log transaction history
            Transaction::create([
                'user_id' => $convert->user_id,
                'title' => 'Airtime to Cash',
                'description' => $description,
                'service' => 'balance',
                'amount' => $convert->settled,
                'type' => 1,
                'trx' => $trx,
            ]);

            $u=User::find($convert->user_id);
            if($convert->type == "wallet"){
                $u->balance+=$convert->settled;
                $u->save();
            }

            $convert->status=1;
            $convert->save();

            $to = $u->email;
            $name = $u->firstname;
            $subject = $title;
            $message = $description . " <br>Thank you for choosing " . $gnl->sitename;
            send_email($to, $name, $subject, $message);

            return back()->with(["success"=>"Airtime Conversion Approved Successfully"]);
        }
    }

    //Bill Hisotry for all users
    public function allBills()
    {
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Bill History";
        $data['bills'] = Transaction::latest()->paginate(20);
        $data['count_bills'] = Transaction::count();
        return view('admin.bills.histories', $data);
    }

    //Bill History Search
    public function billSearch(Request $request){
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Bill Payment History";
        $word=$request->search;
        $data['bills'] = BillsHistory::where([['trx', 'LIKE', '%'.$word.'%']])->orWhere('ref', 'LIKE', '%'.$word.'%')->orWhere('api_req_id', 'LIKE', '%'.$word.'%')->orWhere('recipient', 'LIKE', '%'.$word.'%')->latest()->paginate(20);
        $data['count_bills'] = BillsHistory::where([['trx', 'LIKE', '%'.$word.'%']])->orWhere('ref', 'LIKE', '%'.$word.'%')->orWhere('api_req_id', 'LIKE', '%'.$word.'%')->orWhere('recipient', 'LIKE', '%'.$word.'%')->count();
        $data['count_gb'] = BillsHistory::where([['trx', 'LIKE', '%'.$word.'%']])->orWhere('ref', 'LIKE', '%'.$word.'%')->orWhere('api_req_id', 'LIKE', '%'.$word.'%')->orWhere('recipient', 'LIKE', '%'.$word.'%')->sum('cg');
        return view('admin.bills.histories', $data);
    }

    //Bill History Search
    public function UserbillCal($id){
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Bill Payment History";
        $count_bills = BillsHistory::where('provider', "MTN")->where('service_type', 'internet')->where('user_id', $id)->count();
        $sum_bills = BillsHistory::where('provider', "MTN")->where('service_type', 'internet')->where('user_id', 3)->sum('cg');
        $value = "Count: ".$count_bills." - and Sum: ".$sum_bills;
        return $value;
    }

    //Deposit History
    public function depositHistory(){
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Deposit History";
        $data['deposits'] = Deposit::latest()->take(1500)->get();
        return view('admin.logs.deposits', $data);
    }

    //Transaction History
    public function transactionHistory(){
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Transaction History";
        $data['transactions'] = Transaction::latest()->take(1500)->get();
        return view('admin.logs.transactions', $data);
    }

    //Transfer History
    public function transferHistory(){
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Transfer History";
        $data['transfers'] = Transfer::latest()->take(1500)->get();
        return view('admin.logs.transfers', $data);
    }

    //Convert Airtime History
    public function convertAirtimeHistory(){
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Convert Airtime History";
        $data['convertairtime'] = ConvertAirtimeLog::latest()->take(1500)->get();
        return view('admin.logs.convertairtime', $data);
    }
}
