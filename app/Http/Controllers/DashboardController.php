<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function generateHomepageData(){

    }
}
