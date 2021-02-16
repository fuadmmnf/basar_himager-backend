<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoancollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loancollections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loandisbursement_id');
            $table->string('loancollection_no')->unique();
            $table->double('surcharge');
            $table->double('service_charge_rate');
            $table->double('payment_amount');
            $table->double('pending_loan_amount');
            $table->dateTime('payment_date');
            $table->timestamps();

            $table->foreign('loandisbursement_id')->references('id')->on('loandisbursements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loancollections');
    }
}
