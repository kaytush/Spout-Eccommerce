<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Input;

class StateController extends Controller
{
    //
    public function show(){
        $data['states'] = State::paginate(15);
        return view('admin.state', $data);
    }

    public function act($id){
        $states = State::findorFail($id);
        $states['status'] = 1;
        $res = $states->save();

        if ($res) {
            return back()->with('success', 'State Activated Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating State');
        }
    }

    public function deact($id){
        $states = State::findorFail($id);
        $states['status'] = 0;
        $res = $states->save();

        if ($res) {
            return back()->with('success', 'State Deactivated Successfully!');
        } else {
            return back()->with('alert', 'Problem Updating State');
        }
    }
}
