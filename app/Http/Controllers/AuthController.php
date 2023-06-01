<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use Sentinel;

class AuthController extends Controller
{

    public function authenticate(Request $request){

        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];


        if($request->has("remember")){
            $user = Sentinel::authenticateAndRemember($credentials);
        }else{
            $user = Sentinel::authenticate($credentials);
        }


        if($user){
            return redirect(route('system.module.home'));
        }

        return redirect()->back()->withErrors(["error" => "Wrong credentials"]);
    }


    public function logout(){
        Sentinel::logout();
        return redirect('login');
    }
}
