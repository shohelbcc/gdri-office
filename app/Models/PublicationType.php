<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicationType extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Get the publications associated with the publication type.
     */
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
