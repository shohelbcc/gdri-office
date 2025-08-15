<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'details',
        'start_date',
        'end_date',
        'status',
        'study_area',
        'featured_image',
    ];

    /*
    * The topics associated with the project.
    */
    public function topics()
    {
        return $this->belongsToMany(ProjectTopic::class);
    }
    /**
     * The partners associated with the project.
     */
    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }
}
