<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;

class ApiTaskController extends BaseController
{
    public function index(){
        if((Auth::user()->role) == 2){
            $tasks = Task::with(['project', 'manager', 'developer','contribution'])->latest()->get();
            return $this->sendResponse($tasks, 'Task retrieved successfully.');
        }else if(Auth::user()->role == 1){
            $id = Auth::id();
            $tasks = Task::with(['project', 'manager', 'developer','contribution'])->where('manager_id',$id)->latest()->get();
            return $this->sendResponse($tasks, 'Task retrieved successfully.');
        }
        $id = Auth::id();
        $tasks = Task::with(['project', 'manager', 'developer','contribution'])->where('developer_id',$id)->latest()->get();
        return $this->sendResponse($tasks, 'Task retrieved successfully.');
    }

    public function store(Request $request){
        if((Auth::user()->role) != 1){
            return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|min:10',
            'starting_date' => 'required',
            'ending_date' => 'required',
            'description' => 'required|min:30',
            'project_id' => 'required',
            'manager_id' => 'required',
            'developer_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $task = new Task();
        $task->name = $request->name;
        $task->starting_date = $request->starting_date;
        $task->ending_date = $request->ending_date;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->manager_id = $request->manager_id;
        $task->developer_id = $request->developer_id;
        $task->save();
        return $this->sendResponse($task, 'Task created successfully.');
    }

    public function show($id){
        if((Auth::user()->role) == 2){
            $tasks = Task::with(['project', 'manager', 'developer','contribution'])->where('id',$id)->latest()->get();
            return $this->sendResponse($tasks, 'Task retrieved successfully.');
        }else if(Auth::user()->role == 1){
            $user_id = Auth::id();
            $tasks = Task::with(['project', 'manager', 'developer','contribution'])->where('id',$id)->where('manager_id',$user_id)->latest()->get();
            return $this->sendResponse($tasks, 'Task retrieved successfully.');
        }
        $user_id = Auth::id();
        $tasks = Task::with(['project', 'manager', 'developer','contribution'])->where('id',$id)->where('developer_id',$user_id)->latest()->get();
        return $this->sendResponse($tasks, 'Task retrieved successfully.');
    }

    public function update(Request $request, $id){
        if((Auth::user()->role) != 1){
            return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|min:10',
            'starting_date' => 'required',
            'ending_date' => 'required',
            'description' => 'required|min:30',
            'status' => 'required',
            'project_id' => 'required',
            'manager_id' => 'required',
            'developer_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $task = Task::find($id);
        $task->name = $request->name;
        $task->starting_date = $request->starting_date;
        $task->ending_date = $request->ending_date;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->manager_id = $request->manager_id;
        $task->developer_id = $request->developer_id;
        $task->status = $request->status;
        $task->save();
        return $this->sendResponse($task, 'Task Updated successfully.');
    }

    public function destroy($id){
        if((Auth::user()->role) == 1){
            Task::find($id)->delete();
            return $this->sendResponse([NULL], 'Task Deleted successfully.');
        }
        return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
    }
}
