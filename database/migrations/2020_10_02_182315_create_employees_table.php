<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('designation');
            $table->string('father_name');
            $table->string('mother_name');
            $table->json('present_address');
            $table->json('permanent_address');
            $table->integer('basic_salary');
            $table->integer('special_salary')->default(0);
            $table->integer('loan')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
