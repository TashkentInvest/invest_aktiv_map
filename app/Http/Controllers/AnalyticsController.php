<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(){
        return view('pages.analytics.index');
    }

    public function statistic(){
        return view('pages.analytics.statistic');
    }
}
