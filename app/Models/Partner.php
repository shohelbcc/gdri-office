<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name', 'description', 'logo', 'website',
    ];

    /**
     * The projects associated with the partner.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'partner_project', 'partner_id', 'project_id');
    }
}
