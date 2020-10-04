<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyexpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyexpenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expensecategory_id');
            $table->string('voucher_no')->unique();
            $table->dateTime('date');
            $table->double('amount');
            $table->timestamps();

            $table->foreign('expensecategory_id')->references('id')->on('expensecategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dailyexpenses');
    }
}
