<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index(){
        if(Auth::user()){
            return redirect('/dashboard');
        }
        return view('login');
    }

    public function login(Request $request){
        $request->validate(
            [
                'email'=> 'required|min:10',
                'password'=> 'required|min:4|max:20'
            ]
        );
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/dashboard');
        }
        return redirect()->route('login')->with('message','Login Failed');
    }
}
