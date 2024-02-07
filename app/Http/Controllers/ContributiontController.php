<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContributiontController extends Controller
{
    //
    public function index(){
        if(Auth::user()->role == 2){
            $tasks = Task::with(['contribution','project','manager','developer'])->latest()->paginate(1);
            return view('dashboard.contribution',compact('tasks'));
        }else if(Auth::user()->role == 1){
            $id = Auth::id();
            $tasks = Task::with(['contribution','project','manager','developer'])->where('manager_id',$id)->latest()->paginate(1);
            return view('dashboard.contribution',compact('tasks'));
        }else if(Auth::user()->role == 0){
            $id = Auth::id();
            $tasks = Task::with(['contribution','project','manager','developer'])->where('developer_id',$id)->latest()->paginate(1);
            return view('dashboard.contribution',compact('tasks'));
        }
    }

    public function add_contribution(Request $request,$id){
        if(Auth::user()->role != 0){
            return view('dashboard.dashboard');
        }
        $task_id = $id;
        $developer_id = Auth::id();
        $validator = Validator::make($request->all(),[
            'title'=> 'required|min:10',
            'description'=>'required:min:30'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $contribution = new Contribution();
        $contribution->title = $request->title;
        $contribution->description = $request->description;
        $contribution->task_id = $task_id;
        $contribution->developer_id = $developer_id;
        $contribution->save();
        return response()->json(['message'=>'Working Correclty','data'=>$contribution],200);
    }
}
