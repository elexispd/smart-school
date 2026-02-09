<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // SaaS-level permissions
        $saasPermissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view schools',
            'create schools',
            'edit schools',
            'delete schools',
            'view logs',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'assign roles',
            'view permissions',
            'edit permissions',
        ];

        // School-level permissions
        $schoolPermissions = [
            'view school users',
            'create school users',
            'edit school users',
            'delete school users',
            'view school classes',
            'create school classes',
            'edit school classes',
            'delete school classes',
            'view school reports',
            'manage school settings',
        ];

        foreach ($saasPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission], ['type' => 'saas']);
        }

        foreach ($schoolPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission], ['type' => 'school']);
        }

        // SaaS Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin'], ['type' => 'saas']);
        // super_admin bypasses all permissions in User model

        $admin = Role::firstOrCreate(['name' => 'admin'], ['type' => 'saas']);
        $admin->syncPermissions(
            Permission::whereIn('name', ['view users', 'view schools'])->where('type', 'saas')->get()
        );

        // School Roles
        $schoolAdmin = Role::firstOrCreate(['name' => 'school_admin'], ['type' => 'school']);
        $schoolAdmin->syncPermissions(
            Permission::where('type', 'school')->get()
        );

        $teacher = Role::firstOrCreate(['name' => 'teacher'], ['type' => 'school']);
        $teacher->syncPermissions(
            Permission::whereIn('name', ['view school users', 'view school classes', 'view school reports'])->where('type', 'school')->get()
        );

        $student = Role::firstOrCreate(['name' => 'student'], ['type' => 'school']);
        $student->syncPermissions([]);
    }
}
