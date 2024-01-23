<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEmployeesalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeesalaries', function (Blueprint $table) {
            Schema::table('employeesalaries', function (Blueprint $table) {
                $table->integer('working_days')->default(30);
                $table->integer('basic_salary')->nullable();
                $table->integer('special_salary')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employeesalaries', function (Blueprint $table) {
            $table->dropColumn('working_days');
            $table->dropColumn('basic_salary');
            $table->dropColumn('special_salary');
        });
    }
}
