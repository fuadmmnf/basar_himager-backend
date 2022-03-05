<?php


namespace App\Repositories\Interfaces;


interface ReceiveRepositoryInterface
{
    public function getRecentReceives();
    public function getReceiveStats($year);
    public function getReceiveDetails($sr_no);
    public function getRecentReceiveGroups($year);
    public function getPaginatedReceivesByBookingId($booking_id);
    public function saveReceivegroup(array $request);
    public function getReceiveByGroupId($id);
    public function getReceivesBySearchedQuery($year, $query);

}
