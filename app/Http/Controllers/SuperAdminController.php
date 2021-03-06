<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class SuperAdminController extends Controller
{  

    public function index()
    {  
        $this->AdminAuthCheek();
        return view('admin.dashboard');
    }

    public function logout()
    {
        
        Session::flush(); // ---->Total null
        return Redirect::to('/admin');
    }

    public function AdminAuthCheek()
    {
        $admin_id=Session::get('admin_id');
        if($admin_id){
            return;
        }else{
            return Redirect::to('/admin')->send();
        }
    }

}
