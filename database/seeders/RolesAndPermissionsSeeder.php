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
            'view-hscode',
            'create-hscode',
            'edit-hscode',
            'delete-hscode',
            'approve-hscode',
            
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
            
            // Employee Affairs permissions
            'view-employeeaffairs',
            'create-employeeaffairs',
            'edit-employeeaffairs',
            'delete-employeeaffairs',
            'approve-employeeaffairs',
            
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
        $superadminRole = Role::create(['name' => 'superadmin'])
            ->givePermissionTo(Permission::all());

        // Supervisor role gets all permissions except user management
        $supervisorRole = Role::create(['name' => 'supervisor'])
            ->givePermissionTo(Permission::whereNotIn('name', [
                'view-users',
                // 'create-users',
                // 'edit-users',
                'delete-users',
            ])->get());

        // Create basic roles
        $hscodeRole = Role::create(['name' => 'hscode'])
            ->givePermissionTo([
                'view-hscode',
                'create-hscode',
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

        $employeeAffairsRole = Role::create(['name' => 'employeeaffairs'])
            ->givePermissionTo([
                'view-employeeaffairs',
                'create-employeeaffairs',
            ]);

        // Create manager roles with edit/approve permissions
        $hscodeManager = Role::create(['name' => 'hscodemanager'])
            ->givePermissionTo([
                'view-hscode',
                'edit-hscode',
                'approve-hscode',
            ]);

        $inboundManager = Role::create(['name' => 'inboundmanager'])
            ->givePermissionTo([
                'view-inbound',
                'edit-inbound',
                'approve-inbound',
            ]);

        $storeManager = Role::create(['name' => 'storemanager'])
            ->givePermissionTo([
                'view-store',
                'edit-store',
                'approve-store',
            ]);

        $vnsManager = Role::create(['name' => 'vnsmanager'])
            ->givePermissionTo([
                'view-vns',
                'edit-vns',
                'approve-vns',
            ]);

        $tablesManager = Role::create(['name' => 'tablesmanager'])
            ->givePermissionTo([
                'view-tables',
                'edit-tables',
                'approve-tables',
            ]);

        $employeeAffairsManager = Role::create(['name' => 'employeeaffairsmanager'])
            ->givePermissionTo([
                'view-employeeaffairs',
                'edit-employeeaffairs',
                'approve-employeeaffairs',
            ]);

        // Create test users for each role
        $this->createUserWithRole('supervisor@airmail.com', 'supervisor');
        $this->createUserWithRole('superadmin@airmail.com', 'superadmin');
        
        $this->createUserWithRole('hscodemanager@airmail.com', 'hscodemanager');
        $this->createUserWithRole('inboundmanager@airmail.com', 'inboundmanager');
        $this->createUserWithRole('storemanager@airmail.com', 'storemanager');
        $this->createUserWithRole('vnsmanager@airmail.com', 'vnsmanager');
        $this->createUserWithRole('tablesmanager@airmail.com', 'tablesmanager');
        $this->createUserWithRole('employeeaffairsmanager@airmail.com', 'employeeaffairsmanager');
        
        $this->createUserWithRole('hscode@airmail.com', 'hscode');
        $this->createUserWithRole('inbound@airmail.com', 'inbound');
        $this->createUserWithRole('store@airmail.com', 'store');
        $this->createUserWithRole('vns@airmail.com', 'vns');
        $this->createUserWithRole('tables@airmail.com', 'tables');
        $this->createUserWithRole('employeeaffairs@airmail.com', 'employeeaffairs');
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