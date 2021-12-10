<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttachDeliverygroupAndLoancollection extends Migration
{
    public function up()
    {
        Schema::table('loancollections', function (Blueprint $table) {
            $table->unsignedBigInteger('deliverygroup_id')->after('loandisbursement_id')->nullable();

            $table->foreign('deliverygroup_id')->references('id')->on('deliverygroups');
        });
    }

    public function down()
    {
        Schema::table('loancollections', function (Blueprint $table) {
            //
        });
    }
}
