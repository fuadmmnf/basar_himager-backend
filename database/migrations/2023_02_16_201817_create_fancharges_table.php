<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFanchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fancharges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->dateTimeTz('date');
            $table->string('srlot_no');
            $table->integer('quantity_bags_fanned');
            $table->integer('total_amount');
            $table->timestamps();
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
        Schema::dropIfExists('fancharges');
    }
}
