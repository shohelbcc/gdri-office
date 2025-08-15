<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title','slug','content','blog_category_id','created_by','status','published_at','excerpt','featured_image',
    ] ;
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'post_author', 'post_id', 'author_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
