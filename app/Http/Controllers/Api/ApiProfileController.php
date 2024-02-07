<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;

class ApiProfileController extends BaseController
{
    public function index(){
        $user = Auth::user();
        return $this->sendResponse($user, 'Profile retrieved successfully.');
    }

    public function update(Request $request){
        $id = Auth::id();
        $input = $request->all();
        if($request->old_email == $request->email){
            $validator = Validator::make($input, [
                'name'=> 'required|min:3',
                'address'=> 'required|min:10'
            ]);
        }else{
            $validator = Validator::make($input, [
                'name'=> 'required|min:3',
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
        $user->save();
        return $this->sendResponse($user, 'Profile updated successfully.');
    }
}
