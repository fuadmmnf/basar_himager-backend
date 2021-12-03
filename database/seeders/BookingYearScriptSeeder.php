<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingYearScriptSeeder extends Seeder
{
    public function run()
    {
        DB::table('bookings')->chunk(1000, function($bookings)
        {
            foreach ($bookings as $booking)
            {
                $booking->booking_year = $booking->booking_time->month > 3 ? ($booking->booking_time->year +1) : $booking->booking_time->year;
                $booking->save();
            }
        });
    }
}
