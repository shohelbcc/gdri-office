<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notice extends Model
{
    protected $fillable = ['title','details','published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Scope to get published notices
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope to get today's notices
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Check if notice is published
     */
    public function isPublished()
    {
        return !is_null($this->published_at) && $this->published_at <= now();
    }

    /**
     * Get formatted published date
     */
    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y, h:i A') : 'Not Published';
    }

    /**
     * Users who have read this notice
     */
    public function readByUsers()
    {
        return $this->belongsToMany(User::class, 'user_notice_reads', 'notice_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Check if user has read this notice
     */
    public function isReadBy($user)
    {
        if (!$user) return false;
        return $user->hasReadNotice($this->id);
    }

    /**
     * Get all the users whom are associated with this notice
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notice', 'notice_id', 'user_id')
                    ->withTimestamps();
    }
}
