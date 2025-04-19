<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisplayNameToRolesTable extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('display_name')->after('name')->nullable();
        });

        // Update existing roles with display names
        $this->seedDisplayNames();
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('display_name');
        });
    }

    protected function seedDisplayNames()
    {
        $roles = [
            'superadmin' => 'Super Admin',
            'supervisor' => 'Supervisor',
            'hscode' => 'HS Code Specialist',
            'hscodemanager' => 'HS Code Manager',
            'inbound' => 'Inbound Specialist',
            'inboundmanager' => 'Inbound Manager',
            'store' => 'Store Specialist',
            'storemanager' => 'Store Manager',
            'vns' => 'VNS Specialist',
            'vnsmanager' => 'VNS Manager',
            'tables' => 'Tables Specialist',
            'tablesmanager' => 'Tables Manager',
            'employeeaffairs' => 'Employee Affairs',
            'employeeaffairsmanager' => 'Employee Affairs Manager',
        ];

        foreach ($roles as $name => $display) {
            DB::table('roles')
                ->where('name', $name)
                ->update(['display_name' => $display]);
        }
    }
}