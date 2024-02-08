<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(){
        if((Auth::user()->role) == 2){
            $projects = Project::with(['task'])->join('users as managers', 'projects.manager', '=', 'managers.id')->select('projects.*', 'managers.name as manager_name')->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->paginate(2);
            return view('dashboard.project', compact('projects'));
        }else if((Auth::user()->role) == 1){
            $id = Auth::id();
            $projects = Project::with(['task'])->join('users as managers', 'projects.manager', '=', 'managers.id')->select('projects.*', 'managers.name as manager_name')->where('managers.id','=',$id)->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->paginate(2);
            return view('dashboard.project', compact('projects'));
        }
        return view('dashboard.dashboard');
    }

    public function add_project(){
        if((Auth::user()->role) == 2){
            $users = User::select("*")->whereNotIn('role',['2'])->get();
            return view('dashboard.project.add_project',compact('users'));
        }
        return view('dashboard.dashboard');
    }

    public function add_new_project(Request $request){
        if((Auth::user()->role) != 2){
            return view('dashboard.dashboard');
        }
        $request->validate(
            [
                'name'=> 'required|min:10',
                'manager'=> 'required',
                'developer'=> 'required',
                'starting_date'=> 'required',
                'ending_date'=>'required',
                'description'=> 'required|min:20'
            ]
        );
        if(is_array($request->developer)){
            $developers = implode(',',$request->developer);
        }
        $developers = $request->developer;
        $files = [];
        if ($request->documents){
            foreach($request->documents as $file){
                $file_name = time().rand(1,99).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('projects'), $file_name);
                $files[] = $file_name;
            }
        }
        $files = implode(',',$files);
        $project = new Project;
        $project->name = $request->name;
        $project->manager = $request->manager;
        $project->developer = $developers;
        $project->starting_date = $request->starting_date;
        $project->ending_date = $request->ending_date;
        $project->file = $files;
        $project->description = $request->description;
        $project->save();
        return redirect()->route('project')->with('message','Project Added Successfully');
    }

    public function edit_project($id){
        if((Auth::user()->role) == 2){
            $project = Project::find($id);
            $users = User::all();
            return view('dashboard.project.edit_project',compact('project','users'));
        }
        return view('dashboard.dashboard');
    }

    public function edit_new_project(Request $request, $id){
        if((Auth::user()->role) != 2){
            return view('dashboard.dashboard');
        }
        $request->validate(
            [
                'name'=> 'required|min:10',
                'manager'=> 'required',
                'developer'=> 'required',
                'starting_date'=> 'required',
                'ending_date'=>'required',
                'status'=>'required',
                'description'=> 'required|min:20'
            ]
        );
        if(is_array($request->developer)){
            $developers = implode(',',$request->developer);
        }
        $developers = $request->developer;
        $files = [];
        if ($request->documents){
            foreach($request->documents as $file){
                $file_name = time().rand(1,99).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('projects'), $file_name);
                $files[] = $file_name;
            }
        }
        $files = implode(',',$files);
        $project = Project::find($id);
        if ($request->documents && $files != ''){
            $old_files = $project->file;
            $old_files_arr = explode(',',$old_files);
            foreach($old_files_arr as $old_files){
                unlink(public_path('/projects/'.$old_files));
            }
        }
        $project->name = $request->name;
        $project->manager = $request->manager;
        $project->developer = $developers;
        $project->starting_date = $request->starting_date;
        $project->ending_date = $request->ending_date;
        if ($request->documents && $files != ''){
            $project->file = $files;
        }
        $project->status = $request->status;
        $project->description = $request->description;
        $project->save();
        return redirect()->route('project')->with('message','Project Updated Successfully');
    }

    public function delete_project($id){
        if((Auth::user()->role) == 2){
            Project::find($id)->delete();
            return redirect()->route('project')->with('message','Project Deleted Successfully');
        }
        return view('dashboard.dashboard');
    }
}
