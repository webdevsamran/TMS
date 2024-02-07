<?php

namespace App\Http\Controllers;

use App\Mail\RegisterConfirmationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    //
    public function index(){
        return view('register');
    }

    public function register(Request $request){
        $request->validate(
            [
                'name'=> 'required|min:3',
                'email'=> 'required|unique:users|min:10',
                'password'=> 'required|min:4|max:20',
                'address'=> 'required|min:10'
            ]
        );
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();
        return redirect()->route('login')->with("message","Register Successfully");
    }
}
