<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinepartentriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinepartentries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machinepart_id');
            $table->integer('type'); // 0 => usage, 1 => entry
            $table->integer('quantity');
            $table->dateTime('time');
            $table->timestamps();

            $table->foreign('machinepart_id')->references('id')->on('machineparts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machinepartentries');
    }
}
