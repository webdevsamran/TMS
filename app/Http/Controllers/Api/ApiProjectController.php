<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiProjectResource;
use App\Http\Controllers\Api\BaseController;

class ApiProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(): JsonResponse
    {
        if((Auth::user()->role) == 2){
            $projects = Project::with(['task'])->join('users as managers', 'projects.manager', '=', 'managers.id')->select('projects.*', 'managers.name as manager_name')->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->get();
            return $this->sendResponse($projects, 'Project retrieved successfully.');
        }else if((Auth::user()->role) == 1){
            $id = Auth::id();
            $projects = Project::with(['task'])->join('users as managers', 'projects.manager', '=', 'managers.id')->select('projects.*', 'managers.name as manager_name')->where('managers.id','=',$id)->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->get();
            return $this->sendResponse($projects, 'Project retrieved successfully.');
        }
        return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        if((Auth::user()->role) != 2){
            return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required|min:10',
            'manager'=> 'required',
            'developer'=> 'required',
            'documents'=> 'required',
            'starting_date'=> 'required',
            'ending_date'=>'required',
            'description'=> 'required|min:20'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $developers = implode(',',$request->developer);
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
        return $this->sendResponse($project, 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        if((Auth::user()->role) == 2){
            $projects = Project::with(['task'])->join('users as managers', 'projects.manager', '=', 'managers.id')->where('projects.id',$id)->select('projects.*', 'managers.name as manager_name')->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->get();
            return $this->sendResponse($projects, 'Products retrieved successfully.');
        }else if((Auth::user()->role) == 1){
            $user_id = Auth::id();
            $projects = Project::with(['task'])->join('users as managers', 'projects.manager', '=', 'managers.id')->where('projects.id',$id)->select('projects.*', 'managers.name as manager_name')->where('managers.id','=',$user_id)->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->get();
            return $this->sendResponse($projects, 'Products retrieved successfully.');
        }
        return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        if((Auth::user()->role) != 2){
            return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
        }
        $input = $request->all();
        if($request->documents){
            $validator = Validator::make($input, [
                'name'=> 'required|min:10',
                'manager'=> 'required',
                'developer'=> 'required',
                'documents'=> 'required',
                'starting_date'=> 'required',
                'ending_date'=>'required',
                'status'=>'required',
                'description'=> 'required|min:20'
            ]);
        }else{
            $validator = Validator::make($input, [
                'name'=> 'required|min:10',
                'manager'=> 'required',
                'developer'=> 'required',
                'starting_date'=> 'required',
                'ending_date'=>'required',
                'status'=> 'required',
                'description'=> 'required|min:20'
            ]);
        }
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $developers = implode(',',$request->developer);
        $files = [];
        if ($request->documents){
            foreach($request->documents as $file){
                $file_name = time().rand(1,99).'.'.$file->extension();
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
        return $this->sendResponse($project, 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        if((Auth::user()->role) == 2){
            Project::find($id)->delete();
            return $this->sendResponse([], 'Product deleted successfully.');
        }
        return $this->sendResponse([NULL],"You Donot Have Authorizations To Access It");
    }

}
