<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // model của Roles
use Spatie\Permission\Models\Permission; // model của Permission

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seeder tạo ra 2 quyền cơ bản admin và user
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        // 1 quyền cao nhất super admin
        Role::create(['name' => 'super-admin']);
        
    }
}
