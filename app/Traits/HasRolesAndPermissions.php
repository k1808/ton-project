<?php

namespace App\Traits;
use App\Models\Permission;
use App\Models\Role;

trait HasRolesAndPermissions
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->role->permissions;
    }
//    /**
//     * @param mixed ...$roles
//     * @return bool
//     */
//    public function hasRole(... $roles ) {
//        foreach ($roles as $role) {
//            if ($this->roles->contains('slug', $role)) {
//                return true;
//            }
//        }
//        return false;
//    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        foreach ($this->permissions() as $per){
            if($per->slug ===$permission){
                return true;
            }
        }
        return false;
    }
//    /**
//     * @param $permission
//     * @return bool
//     */
//    public function hasPermissionTo($permission)
//    {
//        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission->url);
//    }

//    /**
//     * @param $permission
//     * @return bool
//     */
//    public function hasPermissionThroughRole($permission): bool
//    {
//        foreach ($permission->roles as $role){
//            if($this->roles->contains($role)) {
//                return true;
//            }
//        }
//        return false;
//    }
//
//    /**
//     * @param array $permissions
//     * @return mixed
//     */
//    public function getAllPermissions(array $permissions)
//    {
//        return Permission::whereIn('slug',$permissions)->get();
//    }
//
//    /**
//     * @param mixed ...$permissions
//     * @return $this
//     */
//    public function givePermissionsTo(... $permissions)
//    {
//        $permissions = $this->getAllPermissions($permissions);
//        if($permissions === null) {
//            return $this;
//        }
//        $this->permissions()->saveMany($permissions);
//        return $this;
//    }
//
//    /**
//     * @param mixed ...$permissions
//     * @return $this
//     */
//    public function deletePermissions(... $permissions )
//    {
//        $permissions = $this->getAllPermissions($permissions);
//        $this->permissions()->detach($permissions);
//        return $this;
//    }
//    /**
//     * @param mixed ...$permissions
//     * @return HasRolesAndPermissions
//     */
//    public function refreshPermissions(... $permissions )
//    {
//        $this->permissions()->detach();
//        return $this->givePermissionsTo($permissions);
//    }
}
