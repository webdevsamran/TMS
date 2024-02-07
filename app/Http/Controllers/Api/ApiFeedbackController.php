<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;

class ApiFeedbackController extends BaseController
{
    public function index(){
        $projects = Project::with(['task','feedback'])->join('users as managers', 'projects.manager', '=', 'managers.id')->select('projects.*', 'managers.name as manager_name')->where('status',2)->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->get();
        return $this->sendResponse($projects,"Feeback For Projects Retreived");
    }

    public function store(Request $request, $id){
        $project_id = $id;
        $user_id = Auth::id();
        $validator = Validator::make($request->all(),[
            'title'=> 'required|min:10',
            'stars'=> 'required',
            'feedback'=> 'required|min:50'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $feedback = new Feedback();
        $feedback->title = $request->title;
        $feedback->stars = $request->stars;
        $feedback->feedback = $request->feedback;
        $feedback->user_id = $user_id;
        $feedback->project_id = $project_id;
        $feedback->save();
        return $this->sendResponse($feedback,"Feeback submitted successfully");
    }
}
