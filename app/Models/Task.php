<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Define the relationship with the Project model
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Define the relationship with the User model for the manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Define the relationship with the User model for the developer
    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function contribution(){
        return $this->hasMany(Contribution::class);
    }
}
