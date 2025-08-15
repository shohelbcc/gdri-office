<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTopic extends Model
{
    protected $fillable = [
        'name','description',
    ];

    /**
     * The projects associated with the topic.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_project_topic', 'project_topic_id', 'project_id');
    }

    /**
     * Get the publications associated with the project topic.
     */
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
