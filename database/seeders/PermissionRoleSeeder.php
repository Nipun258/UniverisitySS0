<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all permissions
        $permissions = DB::table('permissions')->get();

        // Role IDs to assign permissions to
        $roleIds = [1, 2];

        // Prepare data for insertion
        $roleHasPermissions = [];

        foreach ($roleIds as $roleId) {
            foreach ($permissions as $permission) {
                $roleHasPermissions[] = [
                    'permission_id' => $permission->id,
                    'role_id' => $roleId,
                ];
            }
        }

        // Insert data into role_has_permissions table
        DB::table('role_has_permissions')->insert($roleHasPermissions);
    }
}
