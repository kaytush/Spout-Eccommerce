<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use Livewire\Component;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    private $theme;

    public function __construct()
    {
        $this->theme = GeneralSettings::first()->theme; // theme name
    }

    // Home Functions Starts Here
    public function index(){
        $data['page_title'] = "Welcome Back";
        return view('theme.'.$this->theme.'.frontend.index', $data);
    }

    public function about(){
        $data['page_title'] = "About Us";
        return view('theme.'.$this->theme.'.frontend.about', $data);
    }

    public function help(){
        $data['page_title'] = "Help";
        return view('theme.'.$this->theme.'.frontend.help', $data);
    }

    public function contact(){
        $data['page_title'] = "Contact Us";
        return view('theme.'.$this->theme.'.frontend.contact', $data);
    }
}
