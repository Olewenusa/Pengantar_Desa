<?php

namespace Database\Seeders;

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
        Role::create([
            'id' => 1,
            'name' => 'Admin',
        ]);Role::create([
            'id' => 2,
            'name' => 'User',
        ]);Role::create([
            'id' => 3,
            'name' => 'Kepala RT',
        ]);Role::create([
            'id' => 4,
            'name' => 'Kepala RW',
        ]);Role::create([
            'id' => 5,
            'name' => 'Kepala Desa',
        ]);Role::create([
            'id' => 6,
            'name' => 'Staff Desa',
        ]);
    }
}
