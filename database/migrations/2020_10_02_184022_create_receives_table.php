<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receivegroup_id');
            $table->unsignedBigInteger('booking_id');
            $table->string('sr_no')->unique();
            $table->string('lot_no');
            $table->integer('booking_currently_left');
            $table->json('transport');
            $table->integer('status')->default(0); // 0=> received, 1=>loaded
            $table->enum('palot_status', ['load', 'first', 'second', 'third', 'fourth'])->nullable();
            $table->timestamps();

            $table->foreign('receivegroup_id')->references('id')->on('receivegroups');
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
        Schema::dropIfExists('receives');
    }
}
