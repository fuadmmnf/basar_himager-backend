<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpenseVoucherRemarks extends Migration
{
    public function up()
    {
        Schema::table('dailyexpenses', function (Blueprint $table) {
            $table->string('remarks')->default('')->after('amount');
        });
    }

    public function down()
    {
        Schema::table('dailyexpenses', function (Blueprint $table) {
            //
        });
    }
}
