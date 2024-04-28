<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userPermission = Permission::whereIn('slug', [
            'edit-profile'
        ])->get();

        $user = new Role();
        $user->name = 'User';
        $user->slug = 'user';
        $user->save();
        $user->permissions()->attach($userPermission);

        $customerPermission = Permission::whereIn('slug', [
            'edit-profile',
        ])->get();
        $customer = new Role();
        $customer->name = 'Customer';
        $customer->slug = 'customer';
        $customer->save();
        $customer->permissions()->attach($customerPermission);

        $executorPermission = Permission::whereIn('slug', [
            'edit-profile',
        ])->get();
        $executor = new Role();
        $executor->name = 'Executor';
        $executor->slug = 'executor';
        $executor->save();
        $executor->permissions()->attach($executorPermission);
        $moderatorPermission = Permission::whereIn('slug', [
            'edit-profile',
        ])->get();
        $moderator = new Role();
        $moderator->name = 'Moderator';
        $moderator->slug = 'moderator';
        $moderator->save();
        $moderator->permissions()->attach($moderatorPermission);
        $adminPermission = Permission::whereIn('slug', [
            'edit-profile',
            'manage-RBAC'
        ])->get();
        $admin = new Role();
        $admin->name = 'Admin';
        $admin->slug = 'admin';
        $admin->save();
        $admin->permissions()->attach($adminPermission);
    }
}
