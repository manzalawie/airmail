<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // HS Code permissions
            'view-hs-code',
            'create-hs-code',
            'edit-hs-code',
            'delete-hs-code',
            'approve-hs-code',

            // Sorting permissions
            'view-sorting',
            'create-sorting',
            'edit-sorting',
            'delete-sorting',
            'approve-sorting',
            
            // Inbound permissions
            'view-inbound',
            'create-inbound',
            'edit-inbound',
            'delete-inbound',
            'approve-inbound',
            
            // Store permissions
            'view-store',
            'create-store',
            'edit-store',
            'delete-store',
            'approve-store',
            
            // VNS permissions
            'view-vns',
            'create-vns',
            'edit-vns',
            'delete-vns',
            'approve-vns',

            // Tables permissions
            'view-tables',
            'create-tables',
            'edit-tables',
            'delete-tables',
            'approve-tables',

            // Returned Items permissions
            'view-returned-items',
            'create-returned-items',
            'edit-returned-items',
            'delete-returned-items',
            'approve-returned-items',
            
            // Employee Affairs permissions
            'view-employee-affairs',
            'create-employee-affairs',
            'edit-employee-affairs',
            'delete-employee-affairs',
            'approve-employee-affairs',
            
            // Management Statistics permissions
            'view-management-statistics',
            'create-management-statistics',
            'edit-management-statistics',
            'delete-management-statistics',
            'approve-management-statistics',
            
            // User management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create superadmin role with ALL permissions
        $superadminRole = Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());

        // Supervisor role gets all permissions except user management
        $supervisorRole = Role::create(['name' => 'supervisor'])
            ->givePermissionTo(Permission::whereNotIn('name', [
                'view-users',
                // 'create-users',
                // 'edit-users',
                // 'delete-users',
            ])->get());

        // Create basic roles
        $hscodeRole = Role::create(['name' => 'hs-code'])
            ->givePermissionTo([
                'view-hs-code',
                'create-hs-code',
            ]);

        $sortingRole = Role::create(['name' => 'sorting'])
            ->givePermissionTo([
                'view-sorting',
                'create-sorting',
            ]);

        $inboundRole = Role::create(['name' => 'inbound'])
            ->givePermissionTo([
                'view-inbound',
                'create-inbound',
            ]);

        $storeRole = Role::create(['name' => 'store'])
            ->givePermissionTo([
                'view-store',
                'create-store',
            ]);

        $vnsRole = Role::create(['name' => 'vns'])
            ->givePermissionTo([
                'view-vns',
                'create-vns',
            ]);

        $tablesRole = Role::create(['name' => 'tables'])
            ->givePermissionTo([
                'view-tables',
                'create-tables',
            ]);

        $returnedItemsRole = Role::create(['name' => 'returned-items'])
            ->givePermissionTo([
                'view-returned-items',
                'create-returned-items',
            ]);

        $employeeAffairsRole = Role::create(['name' => 'employee-affairs'])
            ->givePermissionTo([
                'view-employee-affairs',
                'create-employee-affairs',
            ]);

        $managementStatistics = Role::create(['name' => 'management-statistics'])
            ->givePermissionTo([
                'view-management-statistics',
                'create-management-statistics',
            ]);

        // Create manager roles with edit/approve permissions
        $hscodeManager = Role::create(['name' => 'hs-code-manager'])
            ->givePermissionTo([
                'view-hs-code',
                'edit-hs-code',
                'approve-hs-code',
            ]);

        $hscodeManager = Role::create(['name' => 'sorting-manager'])
            ->givePermissionTo([
                'view-sorting',
                'edit-sorting',
                'approve-sorting',
            ]);

        $inboundManager = Role::create(['name' => 'inbound-manager'])
            ->givePermissionTo([
                'view-inbound',
                'edit-inbound',
                'approve-inbound',
            ]);

        $storeManager = Role::create(['name' => 'store-manager'])
            ->givePermissionTo([
                'view-store',
                'edit-store',
                'approve-store',
            ]);

        $vnsManager = Role::create(['name' => 'vns-manager'])
            ->givePermissionTo([
                'view-vns',
                'edit-vns',
                'approve-vns',
            ]);

        $tablesManager = Role::create(['name' => 'tables-manager'])
            ->givePermissionTo([
                'view-tables',
                'edit-tables',
                'approve-tables',
            ]);

        $returnedItemsManagerRole = Role::create(['name' => 'returned-items-manager'])
            ->givePermissionTo([
                'view-returned-items',
                'edit-returned-items',
                'approve-returned-items',
            ]);

        $employeeAffairsManager = Role::create(['name' => 'employee-affairs-manager'])
            ->givePermissionTo([
                'view-employee-affairs',
                'edit-employee-affairs',
                'approve-employee-affairs',
            ]);

        $managementStatisticsManager = Role::create(['name' => 'management-statistics-manager'])
        ->givePermissionTo([
            'view-management-statistics',
            'edit-management-statistics',
            'approve-management-statistics',
        ]);

        // Create test users for each role
        $this->createUserWithRole('superadmin@airmail.com', 'super-admin');
        $this->createUserWithRole('supervisor@airmail.com', 'supervisor');
        
        $this->createUserWithRole('hscodemanager@airmail.com', 'hs-code-manager');
        $this->createUserWithRole('sortingmanager@airmail.com', 'sorting-manager');
        $this->createUserWithRole('inboundmanager@airmail.com', 'inbound-manager');
        $this->createUserWithRole('storemanager@airmail.com', 'store-manager');
        $this->createUserWithRole('vnsmanager@airmail.com', 'vns-manager');
        $this->createUserWithRole('tablesmanager@airmail.com', 'tables-manager');
        $this->createUserWithRole('returneditemsmanager@airmail.com', 'returned-items-manager');
        $this->createUserWithRole('employeeaffairsmanager@airmail.com', 'employee-affairs-manager');
        $this->createUserWithRole('managementstatisticsmanager@airmail.com', 'management-statistics-manager');
        
        $this->createUserWithRole('hscode@airmail.com', 'hs-code');
        $this->createUserWithRole('sorting@airmail.com', 'sorting');
        $this->createUserWithRole('inbound@airmail.com', 'inbound');
        $this->createUserWithRole('store@airmail.com', 'store');
        $this->createUserWithRole('vns@airmail.com', 'vns');
        $this->createUserWithRole('tables@airmail.com', 'tables');
        $this->createUserWithRole('returneditems@airmail.com', 'returned-items');
        $this->createUserWithRole('employeeaffairs@airmail.com', 'employee-affairs');
        $this->createUserWithRole('managementstatistics@airmail.com', 'management-statistics');
    }

    protected function createUserWithRole($email, $roleName)
    {
        $password = strtolower($roleName) . '@123';

        $user = User::factory()->create([
            'name' => ucfirst($roleName) . ' User',
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $user->assignRole($roleName);

        // Output the credentials for testing purposes
        $this->command->info("Created {$roleName} user: {$email} / {$password}");
    }
}