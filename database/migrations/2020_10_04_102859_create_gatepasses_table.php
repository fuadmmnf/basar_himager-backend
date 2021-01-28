<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatepassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gatepasses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deliverygroup_id');
            $table->string('gatepass_no')->unique();
            $table->dateTime('gatepass_time');
            $table->json('transport');
            $table->timestamps();

            $table->foreign('deliverygroup_id')->references('id')->on('deliverygroups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gatepasses');
    }
}
