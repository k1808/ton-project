<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'name' => 'Edit profile',
                'slug' => 'edit-profile'
            ],
            [
                'name' => 'Manage RBAC',
                'slug' => 'manage-RBAC'
            ],
        ];

        foreach ($data as $item){
            \App\Models\Permission::factory()->create([
                'name' => $item['name'],
                'slug' => $item['slug']
            ]);
        }
    }
}
