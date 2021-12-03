<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingYear extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->year('booking_year')->useCurrent()->after('booking_time');
        });
        Artisan::call('db:seed', array('--class' => 'BookingYearScriptSeeder'));
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
}
