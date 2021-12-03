<?php

namespace Database\Seeders;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingYearScriptSeeder extends Seeder
{
    public function run()
    {
        Booking::orderBy('created_at')->chunk(1000, function($bookings)
        {
            foreach ($bookings as $booking)
            {
                $time = Carbon::parse($booking->booking_time);
                $booking->booking_year = $time->month > 3 ? ($time->year +1) : $time->year;
                $booking->save();
            }
        });
    }
}
