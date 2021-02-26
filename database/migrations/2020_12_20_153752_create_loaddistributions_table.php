<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoaddistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loaddistributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('receive_id');
            $table->unsignedBigInteger('compartment_id');
            $table->unsignedBigInteger('receiveitem_id');
            $table->string('potato_type');
            $table->integer('quantity');
            $table->integer('current_quantity');
            $table->timestamps();

            $table->foreign('receiveitem_id')->references('id')->on('receiveitems');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('compartment_id')->references('id')->on('inventories');
            $table->foreign('receiveitem_id')->references('id')->on('receiveitems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loaddistributions');
    }
}
