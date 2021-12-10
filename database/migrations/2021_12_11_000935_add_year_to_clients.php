<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearToClients extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->year('year')->default('2021');
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
