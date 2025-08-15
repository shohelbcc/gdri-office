<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name','email',
    ] ;
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_author', 'author_id', 'post_id');
    }
}
