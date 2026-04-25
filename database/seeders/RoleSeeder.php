<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $fieldManager = Role::firstOrCreate(['name' => 'field_manager']);
        $fieldGuard = Role::firstOrCreate(['name' => 'field_guard']);
        $player = Role::firstOrCreate(['name' => 'player']);

        $allPermissions = Permission::pluck('name')->toArray();

        $superAdmin->syncPermissions($allPermissions);

        $fieldManager->syncPermissions([
            'fields.manage',
            'planning.manage',
            'pricing.manage',
            'staff.manage',
            'manager.dashboard.view',
            'field.availability.manage',
            'planning.daily.view',
        ]);

        $fieldGuard->syncPermissions([
            'guard.mobile.access',
            'tickets.scan',
            'payments.remaining.collect',
            'planning.daily.view',
            'scan-qr-code',
        ]);

        $player->syncPermissions([
            'fields.browse',
            'reservations.create',
            'reservations.cancel',
            'payments.deposit.pay',
            'tickets.view',
            'reviews.create',
            'profile.manage',
            'favorites.manage',
        ]);
    }
}
