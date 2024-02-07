<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'manager', 'developer', 'starting_date', 'ending_date', 'file', 'description', 'status'];

    public function manager()
    {
        return $this->hasOne(User::class, 'id','manager');
    }

    public function task(){
        return $this->hasMany(Task::class,'project_id','id');
    }

    public function feedback(){
        return $this->hasMany(Feedback::class, 'project_id')
            ->join('users', 'feedback.user_id', '=', 'users.id')
            ->select('feedback.*', 'users.name as user_name');
    }

    public function FeedBackUser(){
        return $this->hasManyThrough(User::class,Feedback::class,'project_id','id');
    }
}
