<?php

namespace App\Observers;

use App\Handlers\TransactionHandler;
use App\Models\Booking;

class BookingObserver
{
    /**
     * Handle the booking "created" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function created(Booking $booking)
    {
        if ($booking->advance_payment > 0) {
            $transactionHandler = new TransactionHandler();
            $transactionHandler->createTransaction(0, $booking->advance_payment, $booking->booking_time,
                $booking, 'New Booking'
            );
        }
        if ($booking->booking_amount > 0) {
            $transactionHandler = new TransactionHandler();
            $transactionHandler->createTransaction(0, $booking->booking_amount, $booking->booking_time,
                $booking, 'Booking Money'
            );
        }

    }

    /**
     * Handle the booking "updated" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function updated(Booking $booking)
    {
        //
    }

    /**
     * Handle the booking "deleted" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function deleted(Booking $booking)
    {
        //
    }

    /**
     * Handle the booking "restored" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function restored(Booking $booking)
    {
        //
    }

    /**
     * Handle the booking "force deleted" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function forceDeleted(Booking $booking)
    {
        //
    }
}
