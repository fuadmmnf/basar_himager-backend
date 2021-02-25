<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnloadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unloadings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('deliveryitem_id');
            $table->unsignedBigInteger('loaddistribution_id');
            $table->string('potato_type');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('deliveryitem_id')->references('id')->on('deliveryitems');
            $table->foreign('loaddistribution_id')->references('id')->on('loaddistributions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unloadings');
    }
}
