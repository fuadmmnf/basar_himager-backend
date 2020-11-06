<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiveitems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receive_id');
            $table->integer('quantity');
            $table->integer('quantity_left');
            $table->string('potatoe_type');
            $table->timestamps();

            $table->foreign('receive_id')->references('id')->on('receives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receiveitems');
    }
}
