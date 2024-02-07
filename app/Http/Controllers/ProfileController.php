<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //

    public function index(){
        $user = Auth::user();
        return view('dashboard.profile',compact('user'));
    }

    public function edit_profile(){
        $user = Auth::user();
        return view('dashboard.profile.update_profile',compact('user'));
    }

    public function update_profile(Request $request,$id){
        $user = User::find($id);
        if($request->old_email == $request->email){
            $request->validate(
                [
                    'name'=> 'required|min:3',
                    'address'=> 'required|min:10'
                ]
            );
        }else{
            $request->validate(
                [
                    'name'=> 'required|min:3',
                    'email'=> 'required|unique:users|min:10',
                    'address'=> 'required|min:10'
                ]
            );
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->address = $request->address;
        $user->save();
        return redirect()->route('profile')->with("message","Profile Updated Successfully");
    }
}
