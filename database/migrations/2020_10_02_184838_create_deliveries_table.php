<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deliverygroup_id');
            $table->unsignedBigInteger('booking_id');
            $table->integer('bags_currently_remaining');
            $table->double('cost_per_bag');
            $table->integer('quantity_bags_fanned')->default(0);
            $table->double('fancost_per_bag')->default(0);
            $table->double('do_charge');
            $table->double('total_charge');
            $table->double('charge_from_booking_amount');
            $table->timestamps();

            $table->foreign('deliverygroup_id')->references('id')->on('deliverygroups');
            $table->foreign('booking_id')->references('id')->on('bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
