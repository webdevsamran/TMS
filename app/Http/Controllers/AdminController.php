<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index(){
        $totalProjects = Project::count();
        $completedProjects = Project::where('status',2)->count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status',2)->count();
        $totalContributions = Contribution::count();
        return view('dashboard.dashboard',compact('totalProjects','completedProjects','totalTasks','completedTasks','totalContributions'));
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
