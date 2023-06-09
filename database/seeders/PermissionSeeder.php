<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'pharmacy_access',
            'pharmacy_edit',
            'pharmacy_create',
            'pharmacy_delete',
            'doctor_access',
            'doctor_edit',
            'doctor_create',
            'doctor_delete',
            'doctor_ban',
            'user_access',
            'user_edit',
            'user_create',
            'user_delete',
            'governorate_access',
            'governorate_edit',
            'governorate_create',
            'governorate_delete',
            'medicine_access',
            'medicine_edit',
            'medicine_create',
            'medicine_delete',
            'area_access',
            'area_edit',
            'area_create',
            'area_delete',
            'user_address_access',
            'user_address_edit',
            'user_address_create',
            'user_address_delete',
            'order_access',
            'order_edit',
            'order_create',
            'order_delete',
            'role_access',
            'role_edit',
            'role_create',
            'role_delete',
            'permission_access',
            'permission_edit',
            'permission_create',
            'permission_delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        // Admin
        $adminPermissions = $permissions;

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo($adminPermissions);

        // Pharmacy
        $pharmacyPermissions = [
            'pharmacy_edit',
            'pharmacy_delete',
            'doctor_access',
            'doctor_edit',
            'doctor_create',
            'doctor_delete',
            'doctor_ban',
            'order_access',
            'order_edit',
            'order_create',
        ];

        $pharmacyRole = Role::where('name', 'pharmacy')->first();
        $pharmacyRole->givePermissionTo($pharmacyPermissions);

        // Doctor
        $doctorPermissions = [
            'doctor_edit',
            'order_access',
            'order_edit',
            'order_create',
        ];

        $doctorRole = Role::where('name', 'doctor')->first();
        $doctorRole->givePermissionTo($doctorPermissions);

        // User
        $userPermissions = [
            'user_edit',
            'user_delete',
            'user_address_access',
            'user_address_edit',
            'user_address_create',
            'user_address_delete',
            'order_access',
            'order_create',
        ];

        $userRole = Role::where('name', 'user')->first();
        $userRole->givePermissionTo($userPermissions);
    }
}
