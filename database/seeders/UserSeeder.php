<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function createUser( $role_id, $phone){
        \App\Models\User::factory()->create([
            'role_id'=>$role_id,
            'phone'=>$phone
        ]);
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUser(5, '1');
        $this->createUser(4, '2');
        $this->createUser(3, '3');
        $this->createUser(2, '4');
        $this->createUser(1, '5');

        \App\Models\User::factory(150)->create([
            'role_id'=>rand(1, 4)
        ]);
    }
}
