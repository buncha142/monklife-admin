<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * สร้าง permission ที่ routes/web.php ใช้ และ role Admin / Member
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = ['สมาชิก', 'จองรถ', 'แจ้งเตือน'];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        Role::findOrCreate('Admin', 'web')->syncPermissions($permissions);
        Role::findOrCreate('Member', 'web')->syncPermissions($permissions);
    }
}
