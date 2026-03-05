<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            'oauth.client.index',
            'oauth.client.create',
            'oauth.client.update',
            'oauth.client.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Auto-assign all oauth permissions to Super-Admin role
        $superAdmin = Role::where('name', 'Super-Admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo($permissions);
        }
    }

    public function down(): void
    {
        Permission::whereIn('name', [
            'oauth.client.index',
            'oauth.client.create',
            'oauth.client.update',
            'oauth.client.delete',
        ])->delete();
    }
};
