<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index(){
        $projects = Project::with(['task','feedback'])->join('users as managers', 'projects.manager', '=', 'managers.id')->select('projects.*', 'managers.name as manager_name')->where('status',2)->addSelect(DB::raw("(SELECT GROUP_CONCAT(name) FROM users WHERE FIND_IN_SET(users.id, projects.developer) > 0) as developer_names"))->paginate(2);
        return view('dashboard.feedback', compact('projects'));
    }

    public function give_feedback($id){
        $project_id = $id;
        return view('dashboard.feedback.add_feedback',compact('project_id'));
    }

    public function add_feedback(Request $request,$id){
        $project_id = $id;
        $user_id = Auth::id();
        $request->validate(
            [
                'title'=> 'required|min:10',
                'stars'=> 'required',
                'feedback'=> 'required|min:50'
            ]
        );
        $feedback = new Feedback();
        $feedback->title = $request->title;
        $feedback->stars = $request->stars;
        $feedback->feedback = $request->feedback;
        $feedback->user_id = $user_id;
        $feedback->project_id = $project_id;
        $feedback->save();
        return redirect()->route('feedback');
    }
}
