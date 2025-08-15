<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'assigned_by',
        'title',
        'description',
        'assigned_date',
        'completed_date',
        'priority',
        'project',
        'status',
    ];

    // The user who assigned this task
    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // The users this task is assigned to
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'assigned_to');
    }
}
