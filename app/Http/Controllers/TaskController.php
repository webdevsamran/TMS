<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(){
        if((Auth::user()->role) == 2){
            $tasks = Task::with(['project', 'manager', 'developer','contribution'])->latest()->paginate(1);
            return view('dashboard.task',compact('tasks'));
        }else if(Auth::user()->role == 1){
            $id = Auth::id();
            $tasks = Task::with(['project', 'manager', 'developer','contribution'])->where('manager_id',$id)->latest()->paginate(1);
            return view('dashboard.task',compact('tasks'));
        }
        $id = Auth::id();
        $tasks = Task::with(['project', 'manager', 'developer','contribution'])->where('developer_id',$id)->latest()->paginate(1);
        return view('dashboard.task',compact('tasks'));
    }

    public function add_task(){
        if((Auth::user()->role) == 1){
            $id = Auth::id();
            $projects = Project::join('users as managers', 'projects.manager', '=', 'managers.id')->select('projects.*', 'managers.name as manager_name')->where('managers.id','=',$id)->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->get();
            return view('dashboard.task.add_task',compact('projects'));
        }
        return view('dashboard.dashboard');
    }

    public function add_new_task(Request $request){
        if((Auth::user()->role) != 1){
            return view('dashboard.dashboard');
        }
        $request->validate([
            'name' => 'required|min:10',
            'starting_date' => 'required',
            'ending_date' => 'required',
            'description' => 'required|min:30',
            'project_id' => 'required',
            'manager_id' => 'required',
            'developer_id' => 'required'
        ]);
        $task = new Task();
        $task->name = $request->name;
        $task->starting_date = $request->starting_date;
        $task->ending_date = $request->ending_date;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->manager_id = $request->manager_id;
        $task->developer_id = $request->developer_id;
        $task->save();
        return redirect()->route('task')->with('message','Task Added Successfully');
    }

    public function edit_task($id){
        if((Auth::user()->role) == 1){
            $task = Task::find($id);
            $project_id = $task->project_id;
            $manager_id = $task->manager_id;
            $project = Project::join('users as managers', 'projects.manager', '=', 'managers.id')->select('projects.*', 'managers.name as manager_name')->where('projects.id','=',$project_id)->where('managers.id','=',$manager_id)->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->first();
            return view('dashboard.task.edit_task',compact('task','project'));
        }
        return view('dashboard.dashboard');
    }

    public function update_task(Request $request, $id){
        if((Auth::user()->role) != 1){
            return view('dashboard.dashboard');
        }
        $request->validate([
            'name' => 'required|min:10',
            'starting_date' => 'required',
            'ending_date' => 'required',
            'description' => 'required|min:30',
            'status' => 'required',
            'project_id' => 'required',
            'manager_id' => 'required',
            'developer_id' => 'required'
        ]);
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
        return redirect()->route('task')->with('message','Task Updated Successfully');
    }

    public function delete_task($id){
        if((Auth::user()->role) == 1){
            Task::find($id)->delete();
            return redirect()->route('task')->with('message','Task Deleted Successfully');
        }
        return view('dashboard.dashboard');
    }
}
