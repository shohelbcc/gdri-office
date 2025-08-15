<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'user_type',
        'password',
    ];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Atendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Leave Application
    public function leave_applications()
    {
        return $this->hasMany(LeaveApplication::class);
    }

    // Tasks this user has assigned to others
    public function tasksAssigned()
    {
        return $this->hasMany(Task::class, 'assigned_by');
    }

    // Tasks this user has been assigned (via pivot table)
    public function assignedTasks()
    {
        return $this->belongsToMany(Task::class, 'task_user', 'assigned_to', 'task_id')->withTimestamps();
    }

    // Post & Comment Management
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    // Notice Read Tracking
    public function readNotices()
    {
        return $this->belongsToMany(Notice::class, 'user_notice_reads', 'user_id', 'notice_id')
                    ->withTimestamps();
    }

    public function hasReadNotice($noticeId)
    {
        return $this->readNotices()->where('notice_id', $noticeId)->exists();
    }

    public function markNoticeAsRead($noticeId)
    {
        if (!$this->hasReadNotice($noticeId)) {
            $this->readNotices()->attach($noticeId);
        }
    }

    public function getUnreadNoticesCount()
    {
        $publishedNotices = Notice::published()->pluck('id');
        $readNotices = $this->readNotices()->pluck('notice_id');
        return $publishedNotices->diff($readNotices)->count();
    }



    // Role Permissions
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }
    public function hasPermission($permission)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }
    public function hasAnyPermission($permissions)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })->exists();
    }
    public function hasAllPermissions($permissions)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })->count() === count($permissions);
    }
    public function hasAnyRoleOrPermission($roles, $permissions)
    {
        return $this->hasAnyRole($roles) || $this->hasAnyPermission($permissions);
    }
    public function hasAllRoleOrPermission($roles, $permissions)
    {
        return $this->hasAllPermissions($permissions) && $this->hasAllRoles($roles);
    }
    public function hasAnyRoleAndPermission($roles, $permissions)
    {
        return $this->hasAnyRole($roles) && $this->hasAnyPermission($permissions);
    }

    /**
     * Get all the notices associated with this user
     */
    public function notices()
    {
        return $this->belongsToMany(Notice::class, 'user_notice', 'user_id', 'notice_id')
                    ->withTimestamps();
    }


}
