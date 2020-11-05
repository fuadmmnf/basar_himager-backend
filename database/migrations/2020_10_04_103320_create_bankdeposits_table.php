<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankdepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankdeposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_id');
            $table->dateTime('time');
            $table->string('si_no');
            $table->integer('type')->default(0); // 0=> deposit, 1=> withdraw
            $table->string('branch');
            $table->double('amount');
            $table->timestamps();

            $table->foreign('bank_id')->references('id')->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bankdeposits');
    }
}
