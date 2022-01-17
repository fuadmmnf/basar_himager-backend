<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSrInfo extends Migration
{
    public function up()
    {
        Schema::table('deliveryitems', function (Blueprint $table) {
            $table->string('srlot_no')->after('potato_type');
//            $table->string('lot_no');
        });
    }

    public function down()
    {
        Schema::table('deliveryitems', function (Blueprint $table) {
            //
        });
    }
}
