<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas =
            [
                ['name' => 'perofile.view', 'permission_group_category_id' => 1, 'guard_name' => 'web'],
                ['name' => 'dashbord.view', 'permission_group_category_id' => 1, 'guard_name' => 'web'],
                ['name' => 'user.view', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.create', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.updation', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.delete', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.inactivate', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.activate', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.show', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.roles.assign', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.roles.remove', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.permissions.assign', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'user.permissions.revoke', 'permission_group_category_id' => 2, 'guard_name' => 'web'],
                ['name' => 'role.index', 'permission_group_category_id' => 3, 'guard_name' => 'web'],
                ['name' => 'role.create', 'permission_group_category_id' => 3, 'guard_name' => 'web'],
                ['name' => 'role.updation', 'permission_group_category_id' => 3, 'guard_name' => 'web'],
                ['name' => 'role.delete', 'permission_group_category_id' => 3, 'guard_name' => 'web'],
                ['name' => 'role.permission.list', 'permission_group_category_id' => 3, 'guard_name' => 'web'],
                ['name' => 'role.permission.update', 'permission_group_category_id' => 3, 'guard_name' => 'web'],
                ['name' => 'role.permissions.revoke', 'permission_group_category_id' => 3, 'guard_name' => 'web'],
                ['name' => 'role.permissions.sync', 'permission_group_category_id' => 3, 'guard_name' => 'web'],
                ['name' => 'permission.index', 'permission_group_category_id' => 4, 'guard_name' => 'web'],
                ['name' => 'permission.create', 'permission_group_category_id' => 4, 'guard_name' => 'web'],
                ['name' => 'permission.updation', 'permission_group_category_id' => 4, 'guard_name' => 'web'],
                ['name' => 'permission.delete', 'permission_group_category_id' => 4, 'guard_name' => 'web'],
                ['name' => 'permission.roles.assign', 'permission_group_category_id' => 4, 'guard_name' => 'web'],
                ['name' => 'permission.roles.remove', 'permission_group_category_id' => 4, 'guard_name' => 'web'],
                ['name' => 'category.type.list', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'category.type.create', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'category.type.updation', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'category.type.delete', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'category.list.check', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'category.list', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'category.create', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'category.updation', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'category.delete', 'permission_group_category_id' => 5, 'guard_name' => 'web'],
                ['name' => 'site.setting.index', 'permission_group_category_id' => 6, 'guard_name' => 'web'],
                ['name' => 'site.settings.update', 'permission_group_category_id' => 6, 'guard_name' => 'web'],
                ['name' => 'site.settings.restore.default', 'permission_group_category_id' => 6, 'guard_name' => 'web'],
            ];

            foreach($datas as $data){
                DB::table('permissions')->insert($data);
            }
    }
}
