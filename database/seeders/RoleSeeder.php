<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'super_admin']);
        $fieldManger = Role::create(['name' => 'field_manager']);
        $fieldGuard = Role::create(['name' => 'field_guard']);
        $player = Role::create(['name' => 'player']);
    }
}
