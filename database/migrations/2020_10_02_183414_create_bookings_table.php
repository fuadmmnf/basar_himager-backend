<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('booking_no')->unique();
            $table->dateTime('booking_time');
            $table->integer('type'); // 0 => normal, 1 => advance
            $table->double('advance_payment');
            $table->double('discount')->default(0.0);
            $table->integer('quantity');
            $table->double('cost_per_bag');
            //Money given at the time of normal booking
            $table->integer('initial_booking_amount');
            $table->integer('booking_amount');
            $table->integer('bags_in')->default(0);
            $table->integer('bags_out')->default(0);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
