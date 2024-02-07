<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\ProcessMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterConfirmationMail;

class UserController extends Controller
{
    public function index(){
        if((Auth::user()->role) == 2){
        $users = User::latest()->paginate(5);
        return view('dashboard.user',compact('users'));
        }
        return view('dashboard.dashboard');
    }

    public function add_user(){
        if((Auth::user()->role) == 2){
            return view('dashboard.user.add_user');
        }
        return view('dashboard.dashboard');
    }

    public function add_new_user(Request $request){
        $request->validate(
            [
                'name'=> 'required|min:3',
                'role'=> 'required',
                'email'=> 'required|unique:users|min:10',
                'password'=> 'required|min:4|max:20',
                'address'=> 'required|min:10'
            ]
        );
        $input = $request->all();
        $data = (object)$input;
        ProcessMail::dispatch($data);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->role = $request->role;
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();
        return redirect()->route('user')->with("message","User Created Successfully");
    }

    public function edit_user($id){
        if((Auth::user()->role) == 2){
        $user = User::find($id);
            return view('dashboard.user.edit_user',compact('user'));
        }
        return view('dashboard.dashboard');
    }

    public function update_user(Request $request,$id){
        if($request->old_email == $request->email){
            $request->validate(
                [
                    'name'=> 'required|min:3',
                    'role'=> 'required',
                    'address'=> 'required|min:10'
                ]
            );
        }else{
            $request->validate(
                [
                    'name'=> 'required|min:3',
                    'role'=> 'required',
                    'email'=> 'required|unique:users|min:10',
                    'address'=> 'required|min:10'
                ]
            );
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->address = $request->address;
        $user->role = $request->role;
        $user->save();
        return redirect()->route('user')->with("message","User Updated Successfully");
    }

    public function delete_user($id){
        if((Auth::user()->role) == 2){
            User::find($id)->delete();
            return redirect()->route('user')->with("message","User Deleted Successfully");
        }
        return view('dashboard.dashboard');
    }
}
