<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;

class ApiContributionController extends BaseController
{
    public function index(){
        if(Auth::user()->role == 2){
            $tasks = Task::with(['contribution','project','manager','developer'])->latest()->paginate(1);
            return $this->sendResponse($tasks,"Contributions Retreived");
        }else if(Auth::user()->role == 1){
            $id = Auth::id();
            $tasks = Task::with(['contribution','project','manager','developer'])->where('manager_id',$id)->latest()->paginate(1);
            return $this->sendResponse($tasks,"Contributions Retreived");
        }else if(Auth::user()->role == 0){
            $id = Auth::id();
            $tasks = Task::with(['contribution','project','manager','developer'])->where('developer_id',$id)->latest()->paginate(1);
            return $this->sendResponse($tasks,"Contributions Retreived");
        }
    }

    public function store(Request $request,$id){
        if(Auth::user()->role != 0){
            return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
        }
        $task_id = $id;
        $developer_id = Auth::id();
        $validator = Validator::make($request->all(),[
            'title'=> 'required|min:10',
            'description'=>'required:min:30'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $contribution = new Contribution();
        $contribution->title = $request->title;
        $contribution->description = $request->description;
        $contribution->task_id = $task_id;
        $contribution->developer_id = $developer_id;
        $contribution->save();
        return $this->sendResponse($contribution, 'Contribution created successfully.');
    }
}
