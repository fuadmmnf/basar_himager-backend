<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFarmerData extends Migration
{
    public function up()
    {
        Schema::table('receives', function (Blueprint $table) {
            $table->json('farmer_info')->nullable()->after('booking_currently_left');
        });
    }

    public function down()
    {
        Schema::table('receives', function (Blueprint $table) {
            //
        });
    }
}
