<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name_ar')->after('name')->nullable();
            $table->string('phone')->after('name_ar')->nullable();
            $table->string('username')->after('phone')->nullable();
            $table->string('national_id')->after('username')->nullable();
            $table->string('address')->after('email')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->unsignedBigInteger('restored_by')->nullable();
            $table->foreign('restored_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'phone', 'username', 'address', 'national_id']);
        });
    }
}
