<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CheckPermissionController extends Controller
{
    public function check(){
        $user = User::find(1);

        // if($user->hasPermissionTo('update_users')){
        //     return 'true';
        // }else{
        //     return 'false';
        // }
        echo asset('images');

        if (!$user->hasPermissionTo('create_users')) {
            dd('Role assignment failed');
        }else{
            return 'success';
        }

        
    }
}
