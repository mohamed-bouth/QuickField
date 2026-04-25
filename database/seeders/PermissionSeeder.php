<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // Super admin
            'kyc.review',
            'users.blacklist.manage',
            'finance.dashboard.view',
            'disputes.manage',
            'settings.manage',
            'manager-requests.review',

            // Manager
            'fields.manage',
            'planning.manage',
            'pricing.manage',
            'staff.manage',
            'manager.dashboard.view',
            'field.availability.manage',

            // Field guard
            'guard.mobile.access',
            'tickets.scan',
            'payments.remaining.collect',
            'planning.daily.view',
            'scan-qr-code',

            // Player
            'fields.browse',
            'reservations.create',
            'reservations.cancel',
            'payments.deposit.pay',
            'tickets.view',
            'reviews.create',
            'profile.manage',
            'favorites.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
