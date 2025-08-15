<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }
    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
    public function hasAnyPermission($permissions)
    {
        return $this->permissions()->whereIn('name', $permissions)->exists();
    }
    public function hasAllPermissions($permissions)
    {
        return $this->permissions()->whereIn('name', $permissions)->count() === count($permissions);
    }
    public function hasAnyRole($roles)
    {
        return $this->whereIn('name', $roles)->exists();
    }
    public function hasAllRoles($roles)
    {
        return $this->whereIn('name', $roles)->count() === count($roles);
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
