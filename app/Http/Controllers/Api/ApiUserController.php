<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;

class ApiUserController extends BaseController
{
    public function index(){
        if((Auth::user()->role) == 2){
            $users = User::latest()->get();
            return $this->sendResponse($users, 'Users retrieved successfully.');
        }
        return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
    }

    public function store(Request $request){
        if((Auth::user()->role) != 2){
            return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required|min:3',
            'role'=> 'required',
            'email'=> 'required|unique:users|min:10',
            'password'=> 'required|min:4|max:20',
            'address'=> 'required|min:10'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->role = $request->role;
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();
        return $this->sendResponse($user, 'User created successfully.');
    }

    public function show($id){
        if((Auth::user()->role) == 2){
        $user = User::find($id);
        return $this->sendResponse($user, 'User created successfully.');
        }
        return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
    }

    public function update(Request $request,$id){
        if((Auth::user()->role) != 2){
            return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
        }
        $input = $request->all();
        if($request->old_email == $request->email){
            $validator = Validator::make($input, [
                'name'=> 'required|min:3',
                'role'=> 'required',
                'address'=> 'required|min:10'
            ]);
        }else{
            $validator = Validator::make($input, [
                'name'=> 'required|min:3',
                    'role'=> 'required',
                    'email'=> 'required|unique:users|min:10',
                    'address'=> 'required|min:10'
            ]);
        }
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
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
        return $this->sendResponse($user, 'User Updated successfully.');
    }

    public function destroy($id){
        if((Auth::user()->role) == 2){
            User::find($id)->delete();
            return $this->sendResponse([NULL], 'User Deleted successfully.');
        }
        return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
    }
}
