<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index(){
        return view('dashboard.login');
    }

    public function adminlogin(Request $request){
        $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);

        $credentials = $request->only('email' , 'password');
        

        $log = Auth::guard('web')->attempt($credentials);
        if($log){
            return redirect()->route('dashboard.index');
        }else{
            Alert::error(('ERROR'), ('the email or password is incorrect'));
            return redirect()->route('login');
            
        }

    }
}
