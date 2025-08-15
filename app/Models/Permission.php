<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_user', 'permission_id', 'user_id');
    }
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }
    public function hasAllRoles($roles)
    {
        return $this->roles()->whereIn('name', $roles)->count() === count($roles);
    }
    public function hasAnyPermission($permissions)
    {
        return $this->whereIn('name', $permissions)->exists();
    }
    public function hasAllPermissions($permissions)
    {
        return $this->whereIn('name', $permissions)->count() === count($permissions);
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
    public function hasAllRoleAndPermission($roles, $permissions)
    {
        return $this->hasAllPermissions($permissions) && $this->hasAllRoles($roles);
    }
}
