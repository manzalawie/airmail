<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returned_items', function (Blueprint $table) {
            $table->id();
            // Date fields
            $table->unsignedTinyInteger('day');   // 1 - 31
            $table->unsignedTinyInteger('month'); // 1 - 12
            $table->year('year');

            // Inbound
            $table->unsignedInteger('warehouse')->default(0);
            $table->unsignedInteger('inbound_transit')->default(0);
            $table->unsignedInteger('inbound_returned')->default(0);
            $table->unsignedInteger('ordinary_mail_transit')->default(0);
            $table->unsignedInteger('ordinary_mail_returned')->default(0);

            // UV (Outbound)
            $table->unsignedInteger('uv_dispatches')->default(0);
            $table->unsignedInteger('uv_items')->default(0);
            $table->unsignedFloat('uv_weight', 10, 2)->default(0);

            // UA (Outbound)
            $table->unsignedInteger('ua_dispatches')->default(0);
            $table->unsignedInteger('ua_items')->default(0);
            $table->unsignedFloat('ua_weight', 10, 2)->default(0);

            // UL (Outbound)
            $table->unsignedInteger('ul_dispatches')->default(0);
            $table->unsignedInteger('ul_items')->default(0);
            $table->unsignedFloat('ul_weight', 10, 2)->default(0);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returned_items');
    }
}
