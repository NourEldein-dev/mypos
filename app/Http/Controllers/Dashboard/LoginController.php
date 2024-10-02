<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    // Show the login form
    public function index() {
        return view('dashboard.login');
    } // end of index

    // Handle the admin login request
    public function adminlogin(Request $request) {
        // Validate the login credentials
        $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        $log = Auth::guard('web')->attempt($credentials);
        if ($log) {
            return redirect()->route('dashboard.index');
        } else {
            // Show error alert if login fails
            Alert::error(('ERROR'), ('the email or password is incorrect'));
            return redirect()->route('login');
        }
    } // end of adminlogin
} // end of controller
