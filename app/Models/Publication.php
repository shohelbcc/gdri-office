<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = ['title', 'description', 'publication_type_id', 'project_topic_id', 'authors', 'published_year', 'link', 'paper_type', 'slug'];

    /**
     * Get the publication type associated with the publication.
     */
    public function publicationType()
    {
        return $this->belongsTo(PublicationType::class);
    }

    /**
     * Get the project topic associated with the publication.
     */
    public function projectTopic()
    {
        return $this->belongsTo(ProjectTopic::class);
    }
}
